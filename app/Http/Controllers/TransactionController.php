<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function buyNow(Request $request)
    {
        $status = ['selesai', 'selesai withdraw'];
        $wallets = Wallet::whereIn('status', $status)
            ->where('users_id', Auth::user()->id)
            ->get();
        $credit = $wallets->sum('credit');
        $debit = $wallets->sum('debit');
        $saldo_user = $credit - $debit;

        $product = Product::find($request->products_id);

        if ($request->price > $saldo_user) return redirect()->back()->with('status', 'uang kurang');
        if ($product->stock == 0) return redirect()->back()->with('status', 'stock habis');

        $order_code = "INV_" . Auth::user()->id . now()->format("dmYHis");
        Transaction::create([
            'status' => 'dibayar',
            'order_code' => $order_code,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'products_id' => $request->products_id,
            'users_id' => Auth::user()->id
        ]);

        Wallet::create([
            'debit' => $request->price,
            'users_id' => Auth::user()->id,
            'status' => 'selesai'
        ]);

        $product->update([
            'stock' => $product->stock - 1
        ]);


        return redirect()->back()->with('status', 'success');
    }

    public function cancelCart($id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            $transaction->delete();
            return redirect()->back()->with('status', 'Cart di cancel');
        } else {
            return redirect()->back()->with('status', 'Transaksi tidak ditemukan.');
        }

        return redirect()->back()->with('status', 'success');
    }

    public function cart()
    {
        $status = ['selesai', 'selesai withdraw'];
        $wallets = Wallet::whereIn('status', $status)
        ->where('users_id', Auth::user()->id)
        ->get();
        $credit = $wallets->sum('credit');
        $debit = $wallets->sum('debit');
        $saldo_user = $credit - $debit;

        $transactions = Transaction::latest()->with('product')->where('status', 'dikeranjang')
            ->where('users_id', Auth::user()->id)->get();

        return view("siswa.cart", compact("transactions", "saldo_user"));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->products_id);
        if ($product->stock < $request->quantity) return redirect()->back()->with('status', 'gagal');
        $same_transaction = Transaction::where("products_id", $request->products_id)->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->first();
        if ($same_transaction) {
            $sum_quantity = $same_transaction->quantity += $request->quantity;
            $same_transaction->update([
                "quantity" => $sum_quantity,
            ]);
        } else {
            Transaction::create([
                "users_id" => Auth::user()->id,
                "products_id" => $request->products_id,
                "status" => "dikeranjang",
                "order_code" => "INV_" . Auth::user()->id . now()->format("dmYHis"),
                "price" => $request->price,
                "quantity" => $request->quantity
            ]);
        }

        return redirect('/')->with('status', 'success add to cart');
    }

    public function buyFromCart()
    {
        $wallet = Wallet::where("users_id", Auth::user()->id)->first();
        $order_code = "INV_" . Auth::user()->id . now()->format("dmYHis");
        $transactionKeranjang = Transaction::with("product")
            ->where("users_id", Auth::user()->id)
            ->where("status", "dikeranjang")
            ->get();
        $totalBayar = 0;

        foreach ($transactionKeranjang as $ts) {
            $totalBayar += ($ts->price * $ts->quantity);
            $produk = $ts->product;
            $jumlah_dibeli = $ts->quantity;
            $stok_saat_ini = $ts->product->stock;

            // if($produk->stock < $jumlah_dibeli) return redirect()->back()->with('status', 'gagal');

            if ($stok_saat_ini >= $jumlah_dibeli) {
                $stok_baru = $stok_saat_ini - $jumlah_dibeli;
                $produk->stock = $stok_baru;
                $produk->save();
            } else {
                return redirect()->back()->with("status", "stock $produk->name kurang");
            }

        }

        Transaction::where("users_id", Auth::user()->id)
            ->where("status", "dikeranjang")
            ->update([
                'status' => 'dibayar',
                'order_code' => $order_code
            ]);

        $wallet->update([
            'debit' => $wallet->debit + $totalBayar,
        ]);


        return redirect()->back()->with('status', 'success');
    }

    public function downloadPerCode($order_code)
    {
        $reports = Transaction::latest()->with("product")->where("order_code", $order_code)->get();
        $code = $order_code;

        return view('download_percode', compact('reports', 'code'));
    }

    public function downloadTransaksiHarian($date)
    {
        if (Auth::user()->roles_id == 1) {
            $reports = Transaction::latest()->with("product")->where('users_id', Auth::user()->id)->whereDate("created_at", "=", $date)->get();
            $code = $date;
        } else {
            $reports = Transaction::latest()->with("product")->whereDate("created_at", "=", $date)->get();
            $code = $date;
        }

        return view('download_perdate', compact('reports', 'code'));
    }

    public function transaksiHarian()
    {

        if (Auth::user()->roles_id != 1) {
            $transactions = Transaction::with('product', 'user')->latest()->get()->groupBy(function ($item) {
                return $item->created_at->toDateString();
            });
        } else {
            $transactions = Transaction::with('product', 'user')->where('users_id', Auth::user()->id)->latest()->get()->groupBy(function ($item) {
                return $item->created_at->toDateString();
            });
        }
        return view('transaksi_harian', compact('transactions'));
    }

    public function downloadAll(Request $request)
    {
        $params = $request->type;
        if (Auth::user()->roles_id == 1 && $request->type == 'topup') {
            $wallets = Wallet::latest()->where('users_id', Auth::user()->id)->get();
            return view('download', compact('wallets', 'params'));
        }

        if (Auth::user()->roles_id == 3 && $request->type == 'ts') {
            $transactions = Transaction::latest()->with("product", "user")->get();
            return view("download", compact("transactions", 'params'));
        }
        if (Auth::user()->roles_id == 2 && $request->type == 'ts') {
            $transactions = Transaction::latest()->with("product", "user")->get();
            return view("download", compact("transactions", 'params'));
        }

        if (Auth::user()->roles_id == 1 && $request->type == 'ts') {
            $transactions = Transaction::latest()->with("product")->where('users_id', Auth::user()->id)->get();
            return view("download", compact("transactions", 'params'));
        }

        if (Auth::user()->roles_id == 1 && $request->type == 'hs') {
            $transactions = Transaction::latest()->with("product")->where('users_id', Auth::user()->id)->get();
            return view("download", compact("transactions", 'params'));
        }
        if (Auth::user()->roles_id == 2 && $request->type == 'hs') {
            $transactions = Transaction::latest()->with("product", "user")->get();
            return view("download", compact("transactions", 'params'));
        }
    }

    public function history(Request $request)
    {
        $status_wallet = ['selesai', 'selesai withdraw'];
        $walletSaldo = Wallet::where('users_id', Auth::user()->id)->whereIn('status', $status_wallet)->get();
        $credit = $walletSaldo->sum('credit');
        $debit = $walletSaldo->sum('debit');
        $status = ['dibayar', 'diambil'];
        $wallets = Wallet::where('users_id', Auth::user()->id)->get();
        $transactions = Transaction::latest()->with('product')->where('users_id', Auth::user()->id)->whereIn('status', $status)->get()->groupBy('order_code');
        $transactionsAll = Transaction::latest()->with('product', 'user')->whereIn('status', $status)->get()->groupBy('order_code');
        if ($request->type == 'topup') return view('siswa.history_topup', compact('wallets', 'credit', 'debit'));
        return view('history', compact('transactions', 'transactionsAll'));
    }
}
