<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function bestseller()
    {
        $productData =  Product::query();
        $product =  Product::where('bestseller', 'true')->get();
        $dataProduct = [];
        foreach ($product as $p) {
            $row['id'] = $p->id;
            $row['kode'] = $p->kode;
            $row['nama'] = $p->nama;
            $row['harga'] = $p->harga;
            $row['is_ready'] = $p->is_ready;
            $row['gambar'] = asset('assets/images/' . $p->gambar);
            array_push($dataProduct, $row);
        }
        return response()->json($dataProduct);
    }

    public function all(Request $request)
    {
        $productData = Product::query();
        if (!empty($request['bestseller'])) {
            $bestseller =  $request['bestseller'];
            $productData->where('bestseller', $bestseller);
            // dd($bestseller);
        }
        if (!empty($request['search'])) {
            $search = "%" . $request['search'] . "%";
            $productData->where('nama', 'like', $search);
        }

        if (!empty($request['is_ready'])) {
            $is_ready = $request['is_ready'];
            $productData->where('is_ready', $is_ready);
        }
        $products = $productData->get();

        return response()->json($products);
    }

    public function detail($id)
    {
        $product =  Product::where('id', $id)->first();
        $row['id'] = $product->id;
        $row['kode'] = $product->kode;
        $row['nama'] = $product->nama;
        $row['harga'] = $product->harga;
        $row['is_ready'] = $product->is_ready;
        $row['gambar'] = asset('assets/images/' . $product->gambar);
        return response()->json($row);
    }

    public function post(Request $request)
    {
        $fotoFile = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $file_extension = $file->getClientOriginalExtension();
            $lokasiFile = public_path() . '/' . 'assets/images';
            $this->fotoFile = 'gambar-' . $request->nama . Str::random(5) . '.' . $file_extension;
            $request->file('gambar')->move($lokasiFile, $this->fotoFile);
            $fotoFile = $this->fotoFile;
        }

        $productLatest = Product::latest('created_at')->first();
        if ($productLatest != null) {
            $nopo = substr($productLatest, 4, 5);
            $no_po = intval($nopo);
            do {
                $number = 'kode-' . str_pad(($no_po++ + 1), 5, "0", STR_PAD_LEFT) . '-' . $this->getRomawi(date('n')) . '-' . date('Y');
            } while ($productLatest->where('kode', $number)->exists());
        } else {
            $number = 'kode-00001' . '-' . $this->getRomawi(date('n')) . '-' . date('Y');
        }

        $empData = [
            'nama' => $request->nama,
            'kode' => $number,
            'harga' => $request->harga,
            'bestseller' => $request->bestseller,
            'is_ready' => $request->is_ready,
            'gambar' => $fotoFile
        ];
        Product::create($empData); //create data berita
        return response()->json([
            'status' => 200,
        ]);
    }

    public function update(Request $request, $id)
    {
        $emp = Product::Find($id);
        $lampiranFulltextFile = null;
        if ($request->hasFile('gambar')) {
            if ($emp->gambar) {
                File::delete(public_path('/assets/images/' . $emp->gambar));
            }
            $file = $request->file('gambar');
            $file_extension = $file->getClientOriginalExtension();
            $lokasiFile = public_path() . '/assets/images';

            $this->lampiranFulltextFile = 'gambar-' . $request->nama . Str::random(5) . '.' . $file_extension;
            $request->file('gambar')->move($lokasiFile, $this->lampiranFulltextFile);
            $lampiranFulltextFile = $this->lampiranFulltextFile;
        } else {
            $this->lampiranFulltextFile = $emp->gambar;
            $lampiranFulltextFile = $this->lampiranFulltextFile;
        }



        $empData = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'bestseller' => $request->bestseller,
            'is_ready' => $request->is_ready,
            'gambar' => $lampiranFulltextFile
        ];
        $emp->update($empData); //update berita
        return response()->json([
            'status' => 200,
        ]);
    }

    public function delete($id)
    {
        $emp = Product::find($id); //mengambil data berita berdasarkan id
        if (File::delete(public_path('/assets/images/' . $emp->gambar))) {
            Product::destroy($id); //delete product berdasarkan id
        } else {
            Product::destroy($id); //delete product berdasarkan id
        }
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dihapus',
        ]);
    }
    function getRomawi($bln)
    {
        switch ($bln) {
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
}
