<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // public function index()
    // {
    //     $product = Product::all();
    //     confirmDelete('Hapus data!', 'Apakah adan yakin ingin menghapus data ini?');
    //     return view('pages.admin.product.index', compact('product'));
    // }
    public function index()
    {
        $data = DB::table('distributors')
            ->join('products', 'distributors.id', '=', 'products.id_distributor')
            ->select('distributors.*', 'products.*')
            ->get();

        confirmDelete('Hapus Data!', 'Apakah anda yakin ingin menghapus data ini?');

        return view('pages.admin.product.index', compact('data'));
    }

    // funnction create
    public function create()
    {
        $distributor = Distributor::all();
        return view('pages.admin.product.create');
    }
    // public function create()
    // {
    //     return view('pages.admin.product.create');
    // }

    // function product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_distributor' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back();
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images/', $imageName);
        }

        $product = Product::create([
            'id_distributor' => $request->id_distributor,
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        if ($product) {
            Alert::success('Berhasil!', 'Produk berhasil ditambahkan!');
            return redirect()->route('admin.product');
        } else {
            Alert::error('Gagal!', 'Produk gagal ditambahkan!');
            return redirect()->back();
        }
    }

    // detail product
    public function detail($id)
    {
        $data = DB::table('distributors')
            ->join('products', 'distributors.id', '=', 'products.id_distributor')
            ->select('products.*', 'distributors.*')
            ->where('products.id', '=', $id)
            ->first();

        return view('pages.admin.product.detail', compact('data'));
    }

    // public function detail($id)
    // {
    //     $product = Product::findOrFail($id);

    //     return view('pages.admin.product.detail', compact('product'));
    // }

    // edit product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $distributor = Distributor::all();

        return view('pages.admin.product.edit', compact('product','distributor'));
    }

    public function update(Request $request, $id)
    {
        // Pertama, validasi input dasar tanpa validasi gambar
        $validator = Validator::make($request->all(), [
            'id_dsitributor' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua data terisi dengan benar!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi gambar secara terpisah jika ada file yang diupload
        if ($request->hasFile('image')) {
            $imageValidator = Validator::make($request->all(), [
                'image' => 'required|mimes:png,jpeg,jpg|max:2048'
            ]);

            if ($imageValidator->fails()) {
                Alert::error('Gagal!', 'Format gambar tidak sesuai! Gunakan format PNG, JPEG, atau JPG');
                return redirect()->back()->withErrors($imageValidator)->withInput();
            }
        }

        try {
            $product = Product::findOrFail($id);
            
            // Penanganan upload gambar
            if ($request->hasFile('image')) {
                // Hapus gambar lama
                if ($product->image) {
                    $oldPath = public_path('images/' . $product->image);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                // Upload gambar baru
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/'), $imageName);
            } else {
                $imageName = $product->image; // Gunakan gambar yang ada jika tidak ada upload baru
            }

            // Update data produk
            $product->update([
                'id_distributor' => $request->id_distributor,
                'name' => $request->name,
                'price' => $request->price,
                'category' => $request->category,
                'description' => $request->description,
                'image' => $imageName,
            ]);

            Alert::success('Berhasil!', 'Produk berhasil diperbarui!');
            return redirect()->route('admin.product');

        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat memperbarui produk!');
            return redirect()->back()->withInput();
        }
    }

    // hapus data product
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $oldPath = public_path('images/' . $product->image);
        
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }
        
        $product->delete();
        
        if ($product) {
            Alert::success('Berhasil!', 'Produk berhasil dihapus!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Produk gagal dihapus!');
            return redirect()->back();
        }
    }


}
