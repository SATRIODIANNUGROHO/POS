<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'FNB001',
                'barang_nama' => 'Oreo',
                'harga_beli' => 10000,
                'harga_jual' => 10900,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'FNB002',
                'barang_nama' => 'Good Time',
                'harga_beli' => 9500,
                'harga_jual' => 10000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 2,
                'barang_kode' => 'BNH001',
                'barang_nama' => 'Nivea Men Face Wash',
                'harga_beli' => 34000,
                'harga_jual' => 34500,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'BNH002',
                'barang_nama' => 'MS Glow Men Face Serum',
                'harga_beli' => 100000,
                'harga_jual' => 101000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 3,
                'barang_kode' => 'BK001',
                'barang_nama' => 'MamyPoko X-Tra Kering',
                'harga_beli' => 70000,
                'harga_jual' => 70500,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode' => 'BK002',
                'barang_nama' => 'Cussons Baby Powder',
                'harga_beli' => 4500,
                'harga_jual' => 5000,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 4,
                'barang_kode' => 'HC001',
                'barang_nama' => 'Wipol Karbol Cemara',
                'harga_beli' => 29500,
                'harga_jual' => 30000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4,
                'barang_kode' => 'HC001',
                'barang_nama' => 'Daia Floral Blossom',
                'harga_beli' => 37500,
                'harga_jual' => 38000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'EP001',
                'barang_nama' => 'Senter Anbolt 90000',
                'harga_beli' => 99500,
                'harga_jual' => 100000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'EP002',
                'barang_nama' => 'Stop Kontak Arde',
                'harga_beli' => 4000,
                'harga_jual' => 5000,
            ]
        ];
        DB::table('m_barang')->insert($data);
    }
}