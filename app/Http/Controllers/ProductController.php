<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $date = now()->format("dmYHis");
        $photoPath = "/photos/$date.png";
        if ($request->hasFile('photo')) {
            $request->file('photo')->move("photos/", "$date.png");
        }

        Product::create([
            "name" => $request->name,
            "price" => $request->price,
            "stock" => $request->stock,
            "photo" => $photoPath,
            "description" => $request->description,
            "categories_id" => $request->categories_id,
            "stand" => $request->stand,
        ]);


        return redirect('/')->with('status', 'success');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $productImagePath = $product->photo;
        $date = now()->format("dmYHis");

        if ($request->hasFile('photo')) {
            $request->file('photo')->move("photos/", "$date.png");
            if (!unlink(public_path($productImagePath))) {
                Storage::delete($product->photo);
            } else {
                Storage::delete($product->photo);
            }
            $photoPath = "/photos/$date.png";
        } else {
            $photoPath = $product->photo;
        }

        $product->update([
            "name" => $request->name,
            "price" => $request->price,
            "stock" => $request->stock,
            "photo" => $photoPath,
            "description" => $request->description,
            "categories_id" => $request->categories_id,
            "stand" => $request->stand
        ]);

        return redirect('/')->with('status', 'success');
    }

    public function destroy($id)
    {
        $productToDelete = Product::find($id);

        if (!is_null($productToDelete)) {
            $photoPath = $productToDelete->photo;

            if (!empty($photoPath)) {
                if (!unlink(public_path($photoPath))) {
                    Storage::delete($productToDelete->photo);
                } else {
                    Storage::delete($productToDelete->photo);
                }
            }
            $productToDelete->delete();
        }
        return redirect('/')->with('status', 'success');
    }

    public function confirmProduct($id){
        $transaction = Transaction::find($id);

        $transaction->update([
            'status' => 'diambil'
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function listConfirm(){
        $status = ['dibayar', 'diambil'];
        $transactions = Transaction::latest()->with('product', 'user')->whereIn('status', $status)->get();
        return view('kantin.confirm', compact('transactions'));
    }
}
