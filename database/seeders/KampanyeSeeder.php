<?php

namespace Database\Seeders;

use App\Models\Kampanye;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

/**
 * Kampanye berbasis kejadian nyata. Setiap fakta dikutip dari laporan resmi/pemberitaan
 * yang tercantum pada kolom sumber_*. Tidak ada angka korban atau donasi yang dikarang.
 * Target dana adalah angka rencana awal aplikasi, bukan angka dari sumber.
 */
class KampanyeSeeder extends Seeder
{
    private const BNPB_16NOV = 'https://www.bnpb.go.id/berita/perkembangan-situasi-dan-penanganan-bencana-di-tanah-air-tanggal-16-november-2026';
    private const BNPB_22NOV = 'https://top-news.id/perkembangan-situasi-dan-penanganan-bencana-di-tanah-air-22-november-2026';
    private const BNPB_KARHUTLA = 'https://www.bnpb.go.id/berita/lebih-dari-3000-ha-lahan-terbakar-di-kalimantan-masih-dalam-penanganan';
    private const BNPB_2026 = 'https://www.bnpb.go.id/berita/bnpb-catat-bencana-hidrometeorologi-dominasi-kejadian-sepanjang-2026';

    public function run(): void
    {
        $kat = Kategori::pluck('id', 'nama');

        foreach ($this->data() as $d) {
            Kampanye::updateOrCreate(
                ['judul' => $d['judul']],
                [
                    'kategori_id'    => $kat[$d['kategori']],
                    'judul_en'       => $d['judul_en'],
                    'penggalang'     => 'Tim GalangKita',
                    'lokasi'         => $d['lokasi'],
                    'deskripsi'      => $d['id'],
                    'deskripsi_en'   => $d['en'],
                    'sumber_nama'    => $d['sumber'],
                    'sumber_url'     => $d['url'],
                    'sumber_tanggal' => $d['tanggal'],
                    'tahun_mulai'    => 2026,
                    'target_dana'    => $d['target'],
                ]
            );
        }
    }

    private function data(): array
    {
        return [
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Rokan Hilir, Riau', 'target' => 150_000_000,
                'judul' => 'Bantuan Banjir Rokan Hilir, Riau', 'judul_en' => 'Flood Relief in Rokan Hilir, Riau',
                'id' => 'Banjir melanda sembilan kepenghuluan di Kecamatan Bangko, Kabupaten Rokan Hilir, sejak Sabtu 14 November 2026 sekitar pukul 06.00 WIB. BNPB mencatat 4.403 KK (17.612 jiwa) terdampak, dengan muka air 30 sampai 40 cm yang belum surut pada 15 November. Kampanye ini menghimpun dukungan untuk kebutuhan dasar warga terdampak.',
                'en' => 'Floods hit nine kepenghuluan in Bangko District, Rokan Hilir Regency, from around 06:00 WIB on Saturday, 14 November 2026. BNPB recorded 4,403 households (17,612 people) affected, with water levels of 30 to 40 cm that had not receded by 15 November. This campaign gathers support for the basic needs of affected residents.',
                'sumber' => 'BNPB', 'url' => self::BNPB_16NOV, 'tanggal' => '2026-11-16',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Pesisir Selatan, Sumatera Barat', 'target' => 75_000_000,
                'judul' => 'Bantuan Banjir Pesisir Selatan, Sumatera Barat', 'judul_en' => 'Flood Relief in Pesisir Selatan, West Sumatra',
                'id' => 'Banjir pada Sabtu 14 November 2026 sekitar pukul 21.12 WIB merendam sembilan nagari di Kecamatan Linggo Sari Baganti, Kabupaten Pesisir Selatan. Sekitar 2.280 jiwa dan kurang lebih 13 hektare sawah terdampak. Banjir surut pada 15 November dan tidak ada warga yang mengungsi; dukungan dibutuhkan untuk pemulihan warga dan lahan pertanian.',
                'en' => 'Floods on Saturday, 14 November 2026 at around 21:12 WIB inundated nine nagari in Linggo Sari Baganti District, Pesisir Selatan Regency. About 2,280 people and roughly 13 hectares of rice fields were affected. The water receded on 15 November and no residents were displaced; support is needed for the recovery of residents and farmland.',
                'sumber' => 'BNPB', 'url' => self::BNPB_16NOV, 'tanggal' => '2026-11-16',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Aceh Selatan, Aceh', 'target' => 40_000_000,
                'judul' => 'Bantuan Banjir Trumon, Aceh Selatan', 'judul_en' => 'Flood Relief in Trumon, South Aceh',
                'id' => 'Banjir pada Minggu 15 November 2026 sekitar pukul 10.57 WIB melanda Desa Lhok Raya dan Seuneubok Pusaka di Kecamatan Trumon Tengah dan Trumon Timur, Kabupaten Aceh Selatan. Sebanyak 15 KK (50 jiwa) terdampak. BPBD masih melakukan pemantauan dan asesmen kebutuhan.',
                'en' => 'Floods on Sunday, 15 November 2026 at around 10:57 WIB hit Lhok Raya and Seuneubok Pusaka villages in Central and East Trumon districts, South Aceh Regency. A total of 15 households (50 people) were affected. The local disaster agency (BPBD) is still monitoring and assessing needs.',
                'sumber' => 'BNPB', 'url' => self::BNPB_16NOV, 'tanggal' => '2026-11-16',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Sambas, Kalimantan Barat', 'target' => 100_000_000,
                'judul' => 'Bantuan Banjir Sambas, Kalimantan Barat', 'judul_en' => 'Flood Relief in Sambas, West Kalimantan',
                'id' => 'Banjir sejak Rabu 18 November 2026 sekitar pukul 19.00 WIB melanda lima kecamatan dan delapan desa di Kabupaten Sambas. Sebanyak 281 KK terdampak dan satu jembatan terdampak. Per 21 November banjir belum surut dan ketinggian air masih naik 15 sampai 100 cm. Kebutuhan mendesak yang dilaporkan: bahan pangan, selimut, dan perahu.',
                'en' => 'Floods since Wednesday, 18 November 2026 at around 19:00 WIB hit five districts and eight villages in Sambas Regency. A total of 281 households were affected, along with one bridge. As of 21 November the water had not receded and was still rising by 15 to 100 cm. Urgent needs reported: food, blankets, and boats.',
                'sumber' => 'BNPB (melalui TOP-NEWS)', 'url' => self::BNPB_22NOV, 'tanggal' => '2026-11-22',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Padang Lawas Utara, Sumatera Utara', 'target' => 100_000_000,
                'judul' => 'Bantuan Banjir Padang Lawas Utara, Sumatera Utara', 'judul_en' => 'Flood Relief in North Padang Lawas, North Sumatra',
                'id' => 'Banjir pada Jumat 20 November 2026 sekitar pukul 07.00 WIB melanda tujuh kecamatan dan sepuluh desa di Padang Lawas Utara. Sekitar 800 KK dan 800 unit rumah terdampak, satu fasilitas pendidikan dan delapan ruas jalan ikut terdampak. Warga dievakuasi menggunakan perahu karet dan banjir berangsur surut.',
                'en' => 'Floods on Friday, 20 November 2026 at around 07:00 WIB hit seven districts and ten villages in North Padang Lawas. About 800 households and 800 houses were affected, along with one educational facility and eight road sections. Residents were evacuated by rubber boat and the water is gradually receding.',
                'sumber' => 'BNPB (melalui TOP-NEWS)', 'url' => self::BNPB_22NOV, 'tanggal' => '2026-11-22',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Maluku Barat Daya dan Kepulauan Tanimbar, Maluku', 'target' => 150_000_000,
                'judul' => 'Tanggap Gempa M7,2 Maluku Barat Daya dan Tanimbar', 'judul_en' => 'Response to the M7.2 Earthquake in Southwest Maluku and Tanimbar',
                'id' => 'Gempa bumi bermagnitudo 7,2 dengan kedalaman 125 km mengguncang wilayah Kabupaten Maluku Barat Daya dan Kepulauan Tanimbar pada Sabtu 21 November 2026 pukul 16.42 WIB. Gempa tidak berpotensi tsunami. Pendataan dampak dan kerusakan bangunan masih berlangsung, sehingga kampanye ini disiapkan untuk mendukung penanganan setelah data kebutuhan tersedia.',
                'en' => 'A magnitude 7.2 earthquake at a depth of 125 km struck Southwest Maluku and the Tanimbar Islands on Saturday, 21 November 2026 at 16:42 WIB. It had no tsunami potential. Impact and building damage are still being assessed, so this campaign is prepared to support the response once needs data is available.',
                'sumber' => 'BNPB (melalui TOP-NEWS)', 'url' => self::BNPB_22NOV, 'tanggal' => '2026-11-22',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Purbalingga, Jawa Tengah', 'target' => 25_000_000,
                'judul' => 'Pemulihan Warga Terdampak Longsor Purbalingga', 'judul_en' => 'Recovery for Landslide-Affected Residents in Purbalingga',
                'id' => 'Tanah longsor pada Rabu 18 November 2026 sekitar pukul 20.00 WIB terjadi di tiga kecamatan dan lima desa di Kabupaten Purbalingga. Empat KK mengungsi dan satu unit rumah rusak berat. Material longsor sudah dibersihkan dan jalan dapat dilalui; dukungan dibutuhkan untuk pemulihan rumah warga.',
                'en' => 'A landslide on Wednesday, 18 November 2026 at around 20:00 WIB struck three districts and five villages in Purbalingga Regency. Four households were displaced and one house was heavily damaged. The debris has been cleared and the road is passable; support is needed to rebuild residents\' homes.',
                'sumber' => 'BNPB (melalui TOP-NEWS)', 'url' => self::BNPB_22NOV, 'tanggal' => '2026-11-22',
            ],
            [
                'kategori' => 'Lingkungan', 'lokasi' => 'Kalimantan Tengah, Barat, dan Selatan', 'target' => 200_000_000,
                'judul' => 'Penanganan Karhutla Kalimantan', 'judul_en' => 'Wildfire Response in Kalimantan',
                'id' => 'Per 25 Oktober 2026, BNPB mencatat 3.392 hektare lahan terbakar di Kalimantan dalam penanganan: Kalimantan Tengah 2.458 ha, Kalimantan Barat 884 ha, dan Kalimantan Selatan 52 ha. Penanganan melibatkan 57.050 personel di enam provinsi dan 61 armada udara, termasuk modifikasi cuaca dan pemantauan drone termal untuk bara di lahan gambut.',
                'en' => 'As of 25 October 2026, BNPB recorded 3,392 hectares of burned land in Kalimantan under active response: Central Kalimantan 2,458 ha, West Kalimantan 884 ha, and South Kalimantan 52 ha. The response involves 57,050 personnel across six provinces and 61 aircraft, including weather modification and thermal drone monitoring for hidden embers in peatland.',
                'sumber' => 'BNPB', 'url' => self::BNPB_KARHUTLA, 'tanggal' => '2026-10-26',
            ],
            [
                'kategori' => 'Lingkungan', 'lokasi' => 'Sumatera Selatan dan Jambi', 'target' => 125_000_000,
                'judul' => 'Penanganan Karhutla Sumatera Selatan dan Jambi', 'judul_en' => 'Wildfire Response in South Sumatra and Jambi',
                'id' => 'Pada periode yang sama, kebakaran lahan di Sumatera tercatat sekitar 990 hektare: Sumatera Selatan sekitar 889 ha, Jambi 89 ha, dan Taman Nasional Way Kambas, Lampung, sekitar 12 ha. Operasi modifikasi cuaca dilakukan dan jarak pandang di Sumatera Selatan dilaporkan membaik.',
                'en' => 'In the same period, land fires in Sumatra were recorded at around 990 hectares: South Sumatra about 889 ha, Jambi 89 ha, and Way Kambas National Park, Lampung, about 12 ha. Weather modification operations were carried out and visibility in South Sumatra was reported to improve.',
                'sumber' => 'BNPB', 'url' => self::BNPB_KARHUTLA, 'tanggal' => '2026-10-26',
            ],
            [
                'kategori' => 'Lingkungan', 'lokasi' => 'Prigen dan Malang, Jawa Timur', 'target' => 100_000_000,
                'judul' => 'Pemulihan Hutan Arjuno-Welirang', 'judul_en' => 'Restoring the Arjuno-Welirang Forest',
                'id' => 'Api terdeteksi pada 16 Oktober 2026 di Gunung Ringgit, Prigen, dan mencapai puncak 291 titik api pada 19 Oktober sebelum merambat ke wilayah Malang. Hingga 25 Oktober dini hari, luas area terbakar tercatat 1.090 hektare. Kampanye ini mendukung pemulihan kawasan hutan setelah kebakaran.',
                'en' => 'Fire was detected on 16 October 2026 on Mount Ringgit, Prigen, and peaked at 291 hotspots on 19 October before spreading into the Malang area. By the early hours of 25 October, the burned area was recorded at 1,090 hectares. This campaign supports forest restoration after the fire.',
                'sumber' => 'BNPB', 'url' => self::BNPB_KARHUTLA, 'tanggal' => '2026-10-26',
            ],
            [
                'kategori' => 'Lingkungan', 'lokasi' => 'Taman Nasional Way Kambas, Lampung', 'target' => 50_000_000,
                'judul' => 'Pemadaman Api di Taman Nasional Way Kambas', 'judul_en' => 'Firefighting in Way Kambas National Park',
                'id' => 'Api di Taman Nasional Way Kambas terdeteksi sejak 22 September 2026. Pada 24 Oktober pukul 06.44 tercatat 34 titik api dengan 16 hektare belum padam. Petugas memasang instalasi selang air hampir 3 km untuk memadamkan api di area yang sulit dijangkau.',
                'en' => 'Fire in Way Kambas National Park was detected on 22 September 2026. On 24 October at 06:44, 34 hotspots were recorded with 16 hectares still burning. Crews installed a water hose line of almost 3 km to fight the fire in hard-to-reach areas.',
                'sumber' => 'BNPB', 'url' => self::BNPB_KARHUTLA, 'tanggal' => '2026-10-26',
            ],
            [
                'kategori' => 'Kemanusiaan', 'lokasi' => 'Papua Tengah dan Papua Pegunungan', 'target' => 150_000_000,
                'judul' => 'Bantuan Kemanusiaan untuk Warga Mengungsi di Papua', 'judul_en' => 'Humanitarian Aid for Displaced Residents in Papua',
                'id' => 'Warga di Papua Tengah dan Papua Pegunungan meninggalkan tempat tinggal akibat gangguan keamanan, dan krisis pengungsian ini disebut telah berlangsung cukup lama. Anggota Komisi XIII DPR RI Anisah Syakur (20 November 2026) menekankan agar kebutuhan dasar pengungsi tidak terabaikan: rasa aman, layanan kesehatan, pendidikan anak, pangan, dan tempat tinggal yang layak. Angka pengungsi bervariasi antarsumber dan belum dikonfirmasi data resmi, sehingga tidak dicantumkan di sini.',
                'en' => 'Residents in Central Papua and Highland Papua have left their homes because of security disturbances, and this displacement crisis is said to have lasted for some time. Member of the House Commission XIII Anisah Syakur (20 November 2026) stressed that the basic needs of displaced people must not be neglected: safety, healthcare, children\'s education, food, and decent shelter. Displacement figures vary between sources and are not confirmed by official data, so none are cited here.',
                'sumber' => 'FPKB DPR RI', 'url' => 'https://www.fraksipkb.com/2026/11/20/pengungsi-di-tanah-papua-anisah-syakur-pkb-jangan-ada-hak-dasar-yang-terabaikan/', 'tanggal' => '2026-11-20',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Bengkulu', 'target' => 150_000_000,
                'judul' => 'Pemulihan Rumah Terdampak Banjir dan Longsor Bengkulu', 'judul_en' => 'Home Recovery After Floods and Landslides in Bengkulu',
                'id' => 'BNPB mencatat banjir dan tanah longsor di Bengkulu, termasuk Kota Bengkulu, Kabupaten Lebong, dan Kabupaten Seluma, dengan sekitar 2.069 unit rumah terdampak. Kampanye ini mendukung pemulihan tempat tinggal warga.',
                'en' => 'BNPB recorded floods and landslides in Bengkulu, including Bengkulu City, Lebong Regency, and Seluma Regency, with around 2,069 houses affected. This campaign supports the recovery of residents\' homes.',
                'sumber' => 'BNPB', 'url' => self::BNPB_2026, 'tanggal' => '2026-11-18',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Tulang Bawang, Lampung', 'target' => 100_000_000,
                'judul' => 'Perbaikan Rumah Terdampak Cuaca Ekstrem Tulang Bawang', 'judul_en' => 'Home Repairs After Extreme Weather in Tulang Bawang',
                'id' => 'Cuaca ekstrem di Desa Setia Bumi, Kabupaten Tulang Bawang, Lampung, berdampak pada 487 unit rumah: 15 rusak berat, 75 rusak sedang, dan 397 rusak ringan. Kampanye ini mendukung perbaikan rumah warga.',
                'en' => 'Extreme weather in Setia Bumi village, Tulang Bawang Regency, Lampung, affected 487 houses: 15 heavily damaged, 75 moderately damaged, and 397 lightly damaged. This campaign supports repairs to residents\' homes.',
                'sumber' => 'BNPB', 'url' => self::BNPB_2026, 'tanggal' => '2026-11-18',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Aceh, Sumatera Utara, dan Sumatera Barat', 'target' => 250_000_000,
                'judul' => 'Pemulihan Pascabencana Sumatra: Aceh, Sumut, dan Sumbar', 'judul_en' => 'Post-Disaster Recovery in Sumatra: Aceh, North Sumatra, and West Sumatra',
                'id' => 'Banjir dan longsor di Aceh, Sumatera Utara, dan Sumatera Barat pada akhir 2025 tercatat menelan 1.138 korban jiwa per 27 Desember 2025 menurut BNPB. BNPB kemudian melaporkan jumlah pengungsi turun signifikan, namun pemulihan tempat tinggal dan layanan dasar masih berjalan. Kampanye ini mendukung tahap pemulihan tersebut.',
                'en' => 'Floods and landslides in Aceh, North Sumatra, and West Sumatra in late 2025 claimed 1,138 lives as of 27 December 2025, according to BNPB. BNPB later reported that the number of displaced people had dropped significantly, but the recovery of housing and basic services is still ongoing. This campaign supports that recovery phase.',
                'sumber' => 'Kompas TV (data BNPB)', 'url' => 'https://www.kompas.tv/nasional/640127/update-bencana-sumatera-per-27-desember-2025-bnpb-korban-jiwa-1-138-orang', 'tanggal' => '2025-12-27',
            ],
            [
                'kategori' => 'Bencana Alam', 'lokasi' => 'Selat Sunda, DIY-Jawa Tengah, dan Jawa Timur', 'target' => 75_000_000,
                'judul' => 'Siaga Erupsi Semeru, Merapi, dan Anak Krakatau', 'judul_en' => 'Eruption Readiness for Semeru, Merapi, and Anak Krakatau',
                'id' => 'Per 30 Oktober 2026 pukul 06.00 WIB, PVMBG menetapkan Gunung Anak Krakatau, Merapi, dan Semeru berstatus Level III (Siaga). BNPB meminta warga dan wisatawan menjauhi zona bahaya: radius 3 km dari Anak Krakatau, sungai berhulu di Merapi saat hujan deras, serta Besuk Kobokan hingga radius 13 km di Semeru. Kampanye ini mendukung kesiapsiagaan warga di sekitar gunung.',
                'en' => 'As of 30 October 2026 at 06:00 WIB, PVMBG set Anak Krakatau, Merapi, and Semeru at Level III (Alert). BNPB asked residents and tourists to stay away from danger zones: a 3 km radius around Anak Krakatau, rivers that rise on Merapi during heavy rain, and Besuk Kobokan up to a 13 km radius at Semeru. This campaign supports preparedness for residents near the volcanoes.',
                'sumber' => 'NU Online (data BNPB dan PVMBG)', 'url' => 'https://www.nu.or.id/nasional/anak-krakatau-merapi-dan-semeru-berstatus-siaga-bnpb-minta-warga-jauhi-kawasan-rawan-bencana-vMoo1', 'tanggal' => '2026-10-31',
            ],
            [
                'kategori' => 'Kesehatan', 'lokasi' => 'Seluruh Indonesia', 'target' => 100_000_000,
                'judul' => 'Pencegahan DBD Menjelang Musim Hujan', 'judul_en' => 'Dengue Prevention Ahead of the Rainy Season',
                'id' => 'Kemenkes mencatat 98.946 kasus demam berdarah dengue dan 265 kematian pada Januari sampai Oktober 2026, tersebar di 467 kabupaten/kota di 33 provinsi. Menjelang musim hujan, pencegahan seperti pemberantasan sarang nyamuk secara rutin dan tidak membiarkan genangan air menjadi penting. Kampanye ini mendukung kegiatan pencegahan di lingkungan warga.',
                'en' => 'The Ministry of Health recorded 98,946 dengue cases and 265 deaths from January to October 2026, spread across 467 districts/cities in 33 provinces. Ahead of the rainy season, prevention such as routine mosquito nest eradication and not leaving standing water is important. This campaign supports prevention activities in communities.',
                'sumber' => 'NU Online (data Kemenkes)', 'url' => 'https://nu.or.id/nasional/kasus-dbd-tembus-98-946-hingga-oktober-2026-perubahan-iklim-perluas-risiko-penularan-XI3Jg', 'tanggal' => '2026-11-19',
            ],
            [
                'kategori' => 'Kesehatan', 'lokasi' => 'Seluruh Indonesia', 'target' => 100_000_000,
                'judul' => 'Gizi Anak Melawan Stunting', 'judul_en' => 'Child Nutrition Against Stunting',
                'id' => 'Survei Status Gizi Indonesia (SSGI) 2024 mencatat prevalensi stunting nasional 19,8%, turun dari 21,5% pada 2023. Jumlah balita stunting terbanyak ada di Jawa Barat (638.000), Jawa Tengah (485.893), dan Jawa Timur (430.780). Angka ini adalah data survei resmi terbaru yang tersedia dari Kemenkes pada saat ini.',
                'en' => 'The 2024 Indonesian Nutrition Status Survey (SSGI) recorded a national stunting prevalence of 19.8%, down from 21.5% in 2023. The largest numbers of stunted toddlers are in West Java (638,000), Central Java (485,893), and East Java (430,780). These are the latest official survey figures available from the Ministry of Health at this time.',
                'sumber' => 'Kemenkes RI (SSGI 2024)', 'url' => 'https://www.kemkes.go.id/id/ssgi-2024-prevalensi-stunting-nasional-turun-menjadi-198', 'tanggal' => '2025-05-26',
            ],
            [
                'kategori' => 'Pendidikan', 'lokasi' => 'Wilayah bencana dan daerah 3T', 'target' => 150_000_000,
                'judul' => 'Perbaikan Sekolah di Wilayah Bencana dan Daerah 3T', 'judul_en' => 'School Repairs in Disaster Areas and Remote Regions',
                'id' => 'Pemerintah menargetkan revitalisasi 11.744 satuan pendidikan pada 2026 dengan anggaran Rp14 triliun, memprioritaskan sekolah terdampak bencana, lalu daerah 3T (tertinggal, terdepan, terluar), lalu sekolah rusak berat. Kampanye ini melengkapi program pemerintah dengan dukungan untuk kebutuhan sekolah yang belum terjangkau.',
                'en' => 'The government targets the revitalisation of 11,744 education units in 2026 with a budget of IDR 14 trillion, prioritising disaster-affected schools, then 3T areas (disadvantaged, frontier, outermost), then heavily damaged schools. This campaign complements the government programme by supporting school needs not yet reached.',
                'sumber' => 'NU Online (Mendikdasmen)', 'url' => 'https://www.nu.or.id/nasional/mendikdasmen-revitalisasi-sekolah-2026-fokus-di-wilayah-bencana-dan-daerah-3t-RXXHi', 'tanggal' => '2026-04-30',
            ],
        ];
    }
}
