<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKeranjangRequest;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class keranjangController extends Controller
{
    public function all()
    {
        $keranjang = Keranjang::all();
        $dataKeranjang = [];
        foreach ($keranjang as $p) {
            $row['id'] = $p->id;
            $row['jumlah_pemesanan'] = $p->jumlah_pemesanan;
            $row['keterangan'] = $p->keterangan;
            $row['products']['id'] = $p->product->id;
            $row['products']['kode'] = $p->product->kode;
            $row['products']['nama'] = $p->product->nama;
            $row['products']['harga'] = $p->product->harga;
            $row['products']['is_ready'] = $p->product->is_ready;
            $row['products']['bestseller'] = $p->product->bestseller;
            $row['products']['gambar'] = asset('assets/images/' . $p->product->gambar);
            array_push($dataKeranjang, $row);
        }
        return response()->json($dataKeranjang);
    }
    public function post(CreateKeranjangRequest $createKeranjangRequest)
    {
        $data = $createKeranjangRequest->validated();
        DB::beginTransaction();
        try {
            Keranjang::create([
                'jumlah_pemesanan' => $data['jumlah_pemesanan'],
                'product_id' => $data['product_id'],
                'keterangan' => $data['keterangan'],
            ]);
            DB::commit();
            return response()->json(['message' => 'Berhasil Menambahkan product ke keranjang']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi dan tangani kesalahan
            DB::rollback();
            // return response()->json(['error' => 'Terjadi kesalahan saat memasukan ke keranjang']);
        }
    }

    public function delete($id)
    {
        Keranjang::where('id', $id)->delete();
        return response()->json(['message' => 'Delete berhasil'], 201);
    }
}
