<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
// use App\Http\Controllers\Admin\ProductController;
use App\Models\User;
Use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\ProductController;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('pages.user.index', compact('products'));
    }

    public function detail_product($id)
    {
        $product = Product::findOrFail($id);

        return view('pages.user.detail', compact('product'));
    }

    public function purchase($productId, $userId)
    {
        $product = Product::findOrFail($productId);
        $user = User::findOrFail($userId);

        if ($user->point >= $product->price){
            $totalPoints = $user->point - $product->price;

            $user->update([
                'points' => $totalPoints,
            ]);
            Alert::success('Berhasil!', 'Produk berhasil dibeli!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Produk point anda tidak cukup!');
            return redirect()->back();
        }
    }

}
