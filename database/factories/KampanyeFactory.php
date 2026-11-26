<?php

namespace Database\Factories;

use App\Models\Kampanye;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class KampanyeFactory extends Factory
{
    protected $model = Kampanye::class;

    private const JUDUL = [
        'Beasiswa untuk 50 Anak Desa Terpencil'            => 'Pendidikan',
        'Bangun Perpustakaan Mini di Kampung Nelayan'       => 'Pendidikan',
        'Seragam dan Buku untuk Anak Yatim'                 => 'Pendidikan',
        'Laptop Bekas untuk Kelas Digital Pesantren'        => 'Pendidikan',
        'Bantu Operasi Jantung Adik Rafa'                   => 'Kesehatan',
        'Biaya Cuci Darah Bapak Slamet'                     => 'Kesehatan',
        'Obat Rutin untuk Penyintas Kanker Anak'            => 'Kesehatan',
        'Ambulans Gratis untuk Desa Sukamaju'               => 'Kesehatan',
        'Darurat Banjir Bandang: Logistik untuk Pengungsi'  => 'Bencana Alam',
        'Bangun Kembali Rumah Korban Longsor'               => 'Bencana Alam',
        'Dapur Umum untuk Korban Gempa'                     => 'Bencana Alam',
        'Air Bersih untuk Wilayah Terdampak Kekeringan'     => 'Bencana Alam',
        'Renovasi Atap Musala Al-Ikhlas'                    => 'Rumah Ibadah',
        'Karpet dan Sound System Masjid Desa'               => 'Rumah Ibadah',
        'Pembangunan Gereja Kecil di Pedalaman'             => 'Rumah Ibadah',
        'Perbaikan Pura dan Balai Banjar'                   => 'Rumah Ibadah',
        'Tanam 10.000 Mangrove di Pesisir'                  => 'Lingkungan',
        'Bank Sampah untuk Kampung Bersih'                  => 'Lingkungan',
        'Sumur Resapan untuk Cegah Banjir'                  => 'Lingkungan',
        'Penghijauan Lereng Gunung Gundul'                  => 'Lingkungan',
    ];

    private const PENGGALANG = [
        'Yayasan Peduli Sesama', 'Komunitas Relawan Nusantara', 'Lazis Al-Ikhlas',
        'Karang Taruna Desa Sukamaju', 'Gerakan Satu Hati', 'Yayasan Cahaya Harapan',
        'Forum Alumni Peduli', 'Rumah Zakat Lokal',
    ];

    public function definition(): array
    {
        $judul = fake()->unique()->randomElement(array_keys(self::JUDUL));
        $kategoriId = Kategori::where('nama', self::JUDUL[$judul])->value('id')
            ?? Kategori::inRandomOrder()->value('id');

        return [
            'kategori_id' => $kategoriId,
            'judul'       => $judul,
            'penggalang'  => fake()->randomElement(self::PENGGALANG),
            'tahun_mulai' => fake()->numberBetween(2024, 2026),
            'target_dana' => fake()->randomElement([10, 15, 25, 40, 50, 75, 100]) * 1000000,
        ];
    }
}
