<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKampanyeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id'    => ['required', 'exists:kategoris,id'],
            'judul'          => ['required', 'string', 'min:3', 'max:150'],
            'judul_en'       => ['nullable', 'string', 'max:150'],
            'penggalang'     => ['required', 'string', 'min:3', 'max:100'],
            'lokasi'         => ['nullable', 'string', 'max:120'],
            'deskripsi'      => ['nullable', 'string', 'max:5000'],
            'deskripsi_en'   => ['nullable', 'string', 'max:5000'],
            'sumber_nama'    => ['nullable', 'string', 'max:150'],
            'sumber_url'     => ['nullable', 'url', 'max:500'],
            'sumber_tanggal' => ['nullable', 'date'],
            'tahun_mulai'    => ['required', 'integer', 'between:2000,' . date('Y')],
            'target_dana'    => ['required', 'integer', 'min:100000'],
            'gambar'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'            => __(':attribute wajib diisi.'),
            'kategori_id.exists'  => __('Kategori yang dipilih tidak valid.'),
            'judul.string'        => __('Judul kampanye harus berupa teks.'),
            'judul.min'           => __('Judul kampanye minimal :min karakter.'),
            'judul.max'           => __('Judul kampanye maksimal :max karakter.'),
            'penggalang.min'      => __('Nama penggalang minimal :min karakter.'),
            'tahun_mulai.integer' => __('Tahun mulai harus berupa bilangan bulat.'),
            'tahun_mulai.between' => __('Tahun mulai harus antara :min sampai :max.'),
            'target_dana.min'     => __('Target dana minimal Rp :min.'),
            'sumber_url.url'      => __('Tautan sumber harus berupa URL lengkap, misalnya https://...'),
            'gambar.image'        => __('File harus berupa gambar.'),
            'gambar.mimes'        => __('Format gambar harus JPG, PNG, atau WEBP.'),
            'gambar.max'          => __('Ukuran gambar maksimal 3 MB.'),
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id' => __('kategori'),
            'judul'       => __('judul'),
            'penggalang'  => __('penggalang'),
            'tahun_mulai' => __('tahun mulai'),
            'target_dana' => __('target dana'),
        ];
    }
}
