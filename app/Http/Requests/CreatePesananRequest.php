<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePesananRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'noMeja' => 'required',
            'nama' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'nama.required' => 'nama harus diisi.',
            'noMeja.required' => 'No meja harus diisi.',
        ];
    }
}
