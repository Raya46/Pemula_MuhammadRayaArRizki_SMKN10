<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function topupAccept($id)
    {
        $wallet = Wallet::find($id);

        $wallet->update([
            'status' => 'selesai'
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function withdrawUser(Request $request)
    {
        $status = ['selesai', 'selesai withdraw'];
        $wallets = Wallet::whereIn('status', $status)
            ->where('users_id', Auth::user()->id)
            ->get();
        $credit = $wallets->sum('credit');
        $debit = $wallets->sum('debit');
        $saldo_user = $credit - $debit;

        // dd($request->debit);
        if ($saldo_user < $request->debit) return redirect()->back()->with('status', 'saldo kurang');

        Wallet::create([
            'debit' => $request->debit,
            'status' => 'proses withdraw',
            'users_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function withdrawAccept(Request $request, $id)
    {
        $status = ['selesai', 'selesai withdraw'];
        $walletUser = Wallet::where('users_id', $request->users_id)->whereIn('status', $status)->get();
        $creditUser = $walletUser->sum('credit');
        $debitUser = $walletUser->sum('debit');
        $saldoUser = $creditUser - $debitUser;

        // dd($saldoUser);
        if ($saldoUser < $request->debit) return redirect()->back()->with('status', 'saldo user kurang');
        $wallet = Wallet::find($id);

        $wallet->update([
            'status' => 'selesai withdraw'
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function topupUser(Request $request)
    {
        Wallet::create([
            'credit' => $request->credit,
            'status' => 'proses',
            'users_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function topupFromBank(Request $request)
    {
        Wallet::create([
            'credit' => $request->credit,
            'status' => 'selesai',
            'users_id' => $request->users_id
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function withdrawBank(Request $request)
    {
        $status = ['selesai',  'selesai withdraw'];
        $wallets = Wallet::whereIn('status', $status)
            ->where('users_id', $request->users_id)
            ->get();
        $credit = $wallets->sum('credit');
        $debit = $wallets->sum('debit');
        $saldo_user = $credit - $debit;

        if ($saldo_user < $request->debit) return redirect()->back()->with('status', 'saldo kurang');

        Wallet::create([
            'debit' => $request->debit,
            'status' => 'selesai withdraw',
            'users_id' => $request->users_id
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function historyTopupBank()
    {
        $wallets = Wallet::with('user')->where('status', 'selesai')->get();
        return view('bank.history_topup_bank', compact('wallets'));
    }
    public function historyWithdrawBank()
    {
        $wallets = Wallet::with('user')->where('status', 'selesai withdraw')->get();
        return view('bank.history_withdraw_bank', compact('wallets'));
    }
}
