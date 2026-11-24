<?php

namespace Database\Seeders;

use App\Models\FieldPost;
use App\Models\Project;
use App\Models\ProjectContributor;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $sigap = Project::updateOrCreate(
            ['slug' => 'sigap'],
            [
                'title' => 'SIGAP',
                'year' => 2026,
                'summary' => 'Sistem informasi tanggap darurat dan pelaporan insiden terintegrasi untuk penanganan cepat pengaduan warga Desa Cibenda.',
                'description' => 'SIGAP (Sistem Informasi Gawat Darurat dan Pengaduan Warga) merupakan platform web tanggap darurat yang dirancang khusus untuk memfasilitasi warga Desa Cibenda dalam melaporkan kondisi darurat dan kebutuhan bantuan cepat, terhubung langsung dengan posko siaga desa dan notifikasi otomatis ke perangkat kewilayahan.',
                'problem_statement' => 'Di wilayah pedesaan dengan kontur perbukitan seperti Desa Cibenda, keterlambatan laporan gawat darurat dan insiden bencana sering kali terjadi akibat ketiadaan kanal komunikasi terpusat. Warga umumnya mengandalkan pesan grup berantai yang lambat direspons, tidak memuat koordinat lokasi akurat, dan sulit dipantau progres penanganannya oleh perangkat desa.',
                'features' => [
                    [
                        'icon' => 'emergency',
                        'title' => 'Peringatan Panik Sekali Sentuh',
                        'description' => 'Warga dapat mengirimkan sinyal darurat beserta foto kejadian dalam hitungan detik langsung dari ponsel pintar.',
                    ],
                    [
                        'icon' => 'location',
                        'title' => 'Pemetaan Titik Insiden GPS',
                        'description' => 'Koordinat kejadian otomatis dipetakan secara presisi pada peta digital operator Balai Desa untuk mempercepat respon lapangan.',
                    ],
                    [
                        'icon' => 'notification',
                        'title' => 'Disposisi Cepat ke Perangkat RT dan RW',
                        'description' => 'Notifikasi instan otomatis diteruskan ke petugas wilayah terkait beserta status tindak lanjut tiket pelaporan.',
                    ],
                ],
                'gallery_images' => [
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Sosialisasi dan pelatihan alur pelaporan darurat kepada relawan siaga bencana.',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Uji coba pengiriman tiket darurat dan respons balasan dari posko balai desa.',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Pendampingan teknis penggunaan antarmuka web operator bersama staf pemerintahan desa.',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Serah terima modul petunjuk operasional sistem tanggap darurat di Balai Desa Cibenda.',
                    ],
                ],
                'partner_name' => 'Desa Cibenda',
                'category' => 'layanan-darurat',
                'tech_stacks' => ['nextjs', 'tailwind', 'postgresql', 'nodejs', 'leaflet'],
                'dashboard_thumbnail' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80',
                'live_url' => 'https://sigap.desa-cibenda.id',
                'supervisor_name' => 'Dr. Hendra Wijaya, M.Kom.',
                'supervisor_title' => 'Dosen Pembina & Penanggung Jawab Proyek',
                'supervisor_photo_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=160&q=80',
                'is_published' => true,
            ]
        );

        $sigapContributors = [
            [
                'name' => 'Naufal Fadhiil',
                'npm' => '230611103',
                'major' => 'S1 Teknik Informatika',
                'role' => 'Tech Lead & Full Stack Developer',
                'avatar_url' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 1,
            ],
            [
                'name' => 'Raka Pratama',
                'npm' => '230611115',
                'major' => 'S1 Teknik Informatika',
                'role' => 'Frontend Developer',
                'avatar_url' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 2,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'npm' => '230611120',
                'major' => 'S1 Teknik Informatika',
                'role' => 'Backend & Database Engineer',
                'avatar_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 3,
            ],
        ];

        foreach ($sigapContributors as $contributor) {
            ProjectContributor::updateOrCreate(
                ['project_id' => $sigap->id, 'npm' => $contributor['npm']],
                $contributor
            );
        }

        $sidutama = Project::updateOrCreate(
            ['slug' => 'sidutama'],
            [
                'title' => 'SIDUtama',
                'year' => 2026,
                'summary' => 'Platform tata kelola administrasi kependudukan dan surat-menyurat digital desa terintegrasi.',
                'description' => 'SIDUtama (Sistem Informasi Desa Universitas Widyatama) menghadirkan digitalisasi buku register kependudukan, pencatatan mutasi warga, dan generator surat pengantar desa otomatis demi mempercepat alur birokrasi warga di kantor desa mitra.',
                'problem_statement' => 'Pengelolaan administrasi kependudukan di kantor desa kerap terkendala oleh tumpukan berkas fisik dan buku register manual. Proses permohonan surat pengantar warga membutuhkan waktu tunggu yang lama serta rentan terjadi duplikasi data saat pencatatan mutasi penduduk.',
                'features' => [
                    [
                        'icon' => 'document',
                        'title' => 'Generator Surat Keterangan Otomatis',
                        'description' => 'Penerbitan surat pengantar dan administrasi desa secara instan berbasis template digital yang terstandarisasi.',
                    ],
                    [
                        'icon' => 'database',
                        'title' => 'Buku Register Kependudukan Terpusat',
                        'description' => 'Pencatatan data keluarga, mutasi keluar masuk, dan status kependudukan warga desa yang terstruktur dan aman.',
                    ],
                    [
                        'icon' => 'analytics',
                        'title' => 'Statistik Demografi Desa Real Time',
                        'description' => 'Visualisasi data demografi usia, mata pencaharian, dan sebaran kewilayahan untuk mendukung pengambilan kebijakan desa.',
                    ],
                ],
                'gallery_images' => [
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Uji coba pencetakan dokumen permohonan surat kependudukan bersama perangkat desa.',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Sesi pelatihan operator database kependudukan di ruang administrasi balai desa.',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Verifikasi sinkronisasi nomor induk kependudukan pada arsip digital desa.',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Evaluasi alur pelayanan administrasi warga bersama kepala seksi pelayanan.',
                    ],
                ],
                'partner_name' => 'Desa Cibenda',
                'category' => 'sistem-desa',
                'tech_stacks' => ['laravel', 'tailwind', 'mysql', 'alpinejs'],
                'dashboard_thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                'live_url' => 'https://sid.desa-cibenda.id',
                'supervisor_name' => 'Dr. Hendra Wijaya, M.Kom.',
                'supervisor_title' => 'Dosen Pembina & Penanggung Jawab Proyek',
                'supervisor_photo_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=160&q=80',
                'is_published' => true,
            ]
        );

        $sidutamaContributors = [
            [
                'name' => 'Ahmad Fauzi',
                'npm' => '220611045',
                'major' => 'S1 Teknik Informatika',
                'role' => 'Full Stack Developer',
                'avatar_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 1,
            ],
            [
                'name' => 'Dinda Kirana',
                'npm' => '220611088',
                'major' => 'S1 Sistem Informasi',
                'role' => 'UI/UX Designer & Frontend',
                'avatar_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 2,
            ],
        ];

        foreach ($sidutamaContributors as $contributor) {
            ProjectContributor::updateOrCreate(
                ['project_id' => $sidutama->id, 'npm' => $contributor['npm']],
                $contributor
            );
        }

        $cimart = Project::updateOrCreate(
            ['slug' => 'cimart'],
            [
                'title' => 'CiMart',
                'year' => 2026,
                'summary' => 'Portal e-katalog dan etalase digital promosi produk unggulan UMKM serta potensi desa binaan.',
                'description' => 'CiMart (Cibenda Smart Market) adalah portal etalase digital terintegrasi yang memberdayakan pelaku usaha mikro, kecil, dan menengah (UMKM) di desa mitra agar dapat mempromosikan komoditas unggulan secara transparan kepada publik.',
                'problem_statement' => 'Pelaku UMKM dan pengrajin lokal di desa binaan memiliki komoditas unggulan berkualitas, namun terkendala akses promosi yang masih bersifat getuk tular dan terbatas pada pasar lokal sekitar. Ketiadaan etalase digital publik menyulitkan potensi desa dikenal oleh konsumen yang lebih luas.',
                'features' => [
                    [
                        'icon' => 'store',
                        'title' => 'Katalog Komoditas Unggulan Digital',
                        'description' => 'Etalase informasi terstruktur untuk produk olahan makanan, kerajinan tangan, dan hasil bumi desa mitra.',
                    ],
                    [
                        'icon' => 'profile',
                        'title' => 'Profil Terverifikasi Pelaku UMKM',
                        'description' => 'Halaman etalase khusus per pengrajin lokal dengan foto produk, legalitas usaha, dan deskripsi bahan baku.',
                    ],
                    [
                        'icon' => 'chat',
                        'title' => 'Integrasi Kontak Langsung Penjual',
                        'description' => 'Akses langsung pembeli ke kontak produsen desa tanpa perantara untuk menjaga keadilan harga komoditas.',
                    ],
                ],
                'gallery_images' => [
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1556742049-0a67c5574f73?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Pendataan produk dan pengambilan foto katalog bersama kelompok wanita tani.',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Wawancara profil usaha mikro pengrajin kerajinan anyaman di Desa Cibenda.',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Simulasi penayangan produk UMKM pada katalog web bersama pengurus BUMDes.',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80',
                        'caption' => 'Penyerahan akun pengelolaan etalase kepada pengelola pusat promosi desa.',
                    ],
                ],
                'partner_name' => 'Desa Cibenda',
                'category' => 'profil-desa',
                'tech_stacks' => ['react', 'tailwind', 'nodejs', 'mysql'],
                'dashboard_thumbnail' => 'https://images.unsplash.com/photo-1556742049-0a67c5574f73?auto=format&fit=crop&w=800&q=80',
                'live_url' => 'https://cimart.desa-cibenda.id',
                'supervisor_name' => 'Dr. Hendra Wijaya, M.Kom.',
                'supervisor_title' => 'Dosen Pembina & Penanggung Jawab Proyek',
                'supervisor_photo_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=160&q=80',
                'is_published' => true,
            ]
        );

        $cimartContributors = [
            [
                'name' => 'Farhan Maulana',
                'npm' => '210611012',
                'major' => 'S1 Teknik Informatika',
                'role' => 'Frontend Developer',
                'avatar_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 1,
            ],
            [
                'name' => 'Budi Santoso',
                'npm' => '210611034',
                'major' => 'S1 Sistem Informasi',
                'role' => 'Backend Developer',
                'avatar_url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 2,
            ],
        ];

        foreach ($cimartContributors as $contributor) {
            ProjectContributor::updateOrCreate(
                ['project_id' => $cimart->id, 'npm' => $contributor['npm']],
                $contributor
            );
        }

        $fieldPosts = [
            [
                'project_id' => $sigap->id,
                'title' => 'Sosialisasi dan Pelatihan Operator Sistem SIGAP di Balai Desa Cibenda',
                'slug' => 'sosialisasi-pelatihan-operator-sigap-desa-cibenda',
                'activity_date' => '2026-02-15',
                'summary' => 'Tim mahasiswa bersama dosen pembimbing melakukan instalasi awal dan pelatihan langsung bagi perangkat serta relawan siaga desa.',
                'content' => 'Sebagai bagian dari implementasi program Diktisaintek Berdampak, tim pengembang menyerahkan modul operasional sistem tanggap darurat SIGAP kepada perwakilan perangkat Desa Cibenda. Kegiatan ini diisi dengan simulasi pelaporan darurat secara langsung dan pendampingan teknis.',
                'cover_image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'project_id' => $sidutama->id,
                'title' => 'Uji Coba Lapangan Sistem Administrasi Kependudukan SIDUtama',
                'slug' => 'uji-coba-lapangan-sistem-administrasi-kependudukan-sidutama',
                'activity_date' => '2026-02-10',
                'summary' => 'Pengujian alur penerbitan surat pengantar dan sinkronisasi data kependudukan secara langsung di kantor pelayanan desa.',
                'content' => 'Pengujian sistem SIDUtama dilakukan bersama staf seksi pemerintahan Desa Cibenda untuk mengevaluasi kecepatan cetak dokumen dan kemudahan verifikasi berkas permohonan warga secara digital.',
                'cover_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'project_id' => $cimart->id,
                'title' => 'Pendataan dan Kurasi Produk Unggulan UMKM Lokal untuk CiMart',
                'slug' => 'pendataan-kurasi-produk-unggulan-umkm-lokal-cimart',
                'activity_date' => '2026-02-05',
                'summary' => 'Kunjungan langsung ke pengrajin dan produsen olahan makanan khas Desa Cibenda untuk pendokumentasian produk dan onboarding sistem.',
                'content' => 'Mahasiswa terjun langsung ke rumah-rumah warga pengrajin dan pelaku usaha mikro di Desa Cibenda guna mengumpulkan deskripsi produk, foto katalog, dan profil penjual untuk ditayangkan di portal CiMart.',
                'cover_image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=80',
            ],
        ];

        foreach ($fieldPosts as $post) {
            FieldPost::updateOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
