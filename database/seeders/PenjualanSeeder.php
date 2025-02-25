<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 3,
                'pembeli' => 'Pembeli 1',
                'penjualan_kode' => 'PJL001',
                'penjualan_tanggal' => '2025-02-20 05:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3,
                'pembeli' => 'Pembeli 2',
                'penjualan_kode' => 'PJL002',
                'penjualan_tanggal' => '2025-02-21 06:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Pembeli 3',
                'penjualan_kode' => 'PJL003',
                'penjualan_tanggal' => '2025-02-22 07:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3,
                'pembeli' => 'Pembeli 4',
                'penjualan_kode' => 'PJL004',
                'penjualan_tanggal' => '2025-02-23 08:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 3,
                'pembeli' => 'Pembeli 5',
                'penjualan_kode' => 'PJL005',
                'penjualan_tanggal' => '2025-02-24 09:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Pembeli 6',
                'penjualan_kode' => 'PJL006',
                'penjualan_tanggal' => '2025-02-25 10:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3,
                'pembeli' => 'Pembeli 7',
                'penjualan_kode' => 'PJL007',
                'penjualan_tanggal' => '2025-02-26 11:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 3,
                'pembeli' => 'Pembeli 8',
                'penjualan_kode' => 'PJL008',
                'penjualan_tanggal' => '2025-02-27 12:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Pembeli 9',
                'penjualan_kode' => 'PJL009',
                'penjualan_tanggal' => '2025-02-28 13:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3,
                'pembeli' => 'Pembeli 10',
                'penjualan_kode' => 'PJL010',
                'penjualan_tanggal' => '2025-03-01 14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}