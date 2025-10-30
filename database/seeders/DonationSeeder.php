<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donation;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $donations = [
            [
                'name' => 'Bantuan Korban Banjir Jakarta',
                'target_amount' => 50000000,
                'description' => 'Donasi untuk membantu korban banjir di wilayah Jakarta dan sekitarnya.',
                'category' => 'Humanity',
                'creator_id' => 1,
            ],
            [
                'name' => 'Pendidikan untuk Anak Papua',
                'target_amount' => 80000000,
                'description' => 'Membantu menyediakan fasilitas belajar untuk anak-anak di Papua.',
                'category' => 'Education',
                'creator_id' => 2,
            ],
            [
                'name' => 'Reboisasi Gunung Ciremai',
                'target_amount' => 60000000,
                'description' => 'Gerakan penghijauan kembali di kawasan Gunung Ciremai.',
                'category' => 'Environment',
                'creator_id' => 3,
            ],
            [
                'name' => 'Pembangunan Sekolah Terpencil di NTT',
                'target_amount' => 100000000,
                'description' => 'Pembangunan ruang kelas dan fasilitas belajar untuk anak-anak di daerah terpencil NTT.',
                'category' => 'Education',
                'creator_id' => 1,
            ],
            [
                'name' => 'Donasi Kemanusiaan Palestina',
                'target_amount' => 150000000,
                'description' => 'Mendukung bantuan medis dan logistik untuk masyarakat Palestina.',
                'category' => 'Humanity',
                'creator_id' => 2,
            ],
            [
                'name' => 'Bersih-Bersih Pantai Bali',
                'target_amount' => 30000000,
                'description' => 'Kegiatan membersihkan sampah plastik di pantai Bali untuk menjaga ekosistem laut.',
                'category' => 'Environment',
                'creator_id' => 3,
            ],
            [
                'name' => 'Beasiswa Mahasiswa Kurang Mampu',
                'target_amount' => 70000000,
                'description' => 'Memberikan beasiswa kepada mahasiswa berprestasi dari keluarga tidak mampu.',
                'category' => 'Education',
                'creator_id' => 1,
            ],
            [
                'name' => 'Bantuan Korban Gempa Cianjur',
                'target_amount' => 90000000,
                'description' => 'Membantu korban gempa Cianjur dengan kebutuhan dasar dan pembangunan rumah.',
                'category' => 'Humanity',
                'creator_id' => 2,
            ],
        ];

        foreach ($donations as $donation) {
            Donation::create($donation);
        }
    }
}
