<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateKeranjangRequest extends FormRequest
{
    public function rules()
    {
        return [
            'jumlah_pemesanan' => 'required|integer',
            'product_id' => 'required',
            'keterangan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'jumlah_pemesanan.required' => 'Jumlah pemesanan harus diisi.',
            'jumlah_pemesanan.integer' => 'Jumlah pemesanan harus berupa angka.',
            'product_id.required' => 'ID Produk harus diisi.',
            'keterangan.required' => 'Keterangan harus diisi.',
        ];
    }
}
