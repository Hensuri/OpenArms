<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logs = [];

        for ($i = 0; $i < 23; $i++) {
            $logs[] = [
                'order_id' => 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6)),
                'user_id' => rand(1, 3),
                'donation_id' => rand(1, 8),
                'gross_amount' => number_format(rand(10000, 1000000) + (rand(0, 99) / 100), 2, '.', ''), // contoh 532451.27
                'is_anon' => (bool) rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'success',
            ];

            // Biar order_id beda waktu, tambahkan delay 1 detik ke now()
            usleep(500000); // 0.05 detik
        }

        DB::table('transaction_logs')->insert($logs);
    }
}
