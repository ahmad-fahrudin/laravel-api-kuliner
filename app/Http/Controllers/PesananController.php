<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePesananRequest;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function post(CreatePesananRequest $createPesananRequest)
    {
        $data = $createPesananRequest->validated();
        // dd($data);
        try {
            Pesanan::create([
                'noMeja' => $data['noMeja'],
                'nama' => $data['nama'],
            ]);
            return response()->json(['message' => 'Berhasil Menambahkan pesanan']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi dan tangani kesalahan
            return response()->json(['error' => 'Terjadi kesalahan saat menambahkan pesanan']);
        }
    }
}
