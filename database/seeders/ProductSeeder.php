<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['kode_produk' => 'PRD-001', 'nama_produk' => 'Indomie Goreng', 'kategori' => 'Mie Instan', 'merek' => 'Indomie', 'satuan' => 'karton', 'jumlah_stok' => 150, 'tgl_kadaluarsa' => '2025-12-01', 'keterangan' => 'Stok gudang utama'],
            ['kode_produk' => 'PRD-002', 'nama_produk' => 'Susu UHT Full Cream', 'kategori' => 'Minuman', 'merek' => 'Ultra', 'satuan' => 'karton', 'jumlah_stok' => 80, 'tgl_kadaluarsa' => '2025-08-15', 'keterangan' => null],
            ['kode_produk' => 'PRD-003', 'nama_produk' => 'Chitato Sapi Panggang', 'kategori' => 'Snack', 'merek' => 'Chitato', 'satuan' => 'karton', 'jumlah_stok' => 200, 'tgl_kadaluarsa' => '2025-09-30', 'keterangan' => null],
            ['kode_produk' => 'PRD-004', 'nama_produk' => 'Teh Botol Sosro', 'kategori' => 'Minuman', 'merek' => 'Sosro', 'satuan' => 'karton', 'jumlah_stok' => 120, 'tgl_kadaluarsa' => '2025-11-20', 'keterangan' => 'Simpan di tempat sejuk'],
            ['kode_produk' => 'PRD-005', 'nama_produk' => 'Biskuit Oreo Original', 'kategori' => 'Biskuit', 'merek' => 'Oreo', 'satuan' => 'karton', 'jumlah_stok' => 95, 'tgl_kadaluarsa' => '2025-10-10', 'keterangan' => null],
            ['kode_produk' => 'PRD-006', 'nama_produk' => 'Milo Activ-Go', 'kategori' => 'Minuman', 'merek' => 'Milo', 'satuan' => 'karton', 'jumlah_stok' => 60, 'tgl_kadaluarsa' => '2026-01-05', 'keterangan' => null],
            ['kode_produk' => 'PRD-007', 'nama_produk' => 'Pocky Coklat', 'kategori' => 'Snack', 'merek' => 'Pocky', 'satuan' => 'karton', 'jumlah_stok' => 75, 'tgl_kadaluarsa' => '2025-07-25', 'keterangan' => 'Mendekati kadaluarsa'],
            ['kode_produk' => 'PRD-008', 'nama_produk' => 'Aqua 600ml', 'kategori' => 'Minuman', 'merek' => 'Aqua', 'satuan' => 'karton', 'jumlah_stok' => 300, 'tgl_kadaluarsa' => '2026-03-01', 'keterangan' => null],
            ['kode_produk' => 'PRD-009', 'nama_produk' => 'Good Day Cappuccino', 'kategori' => 'Minuman', 'merek' => 'Good Day', 'satuan' => 'karton', 'jumlah_stok' => 45, 'tgl_kadaluarsa' => '2025-06-30', 'keterangan' => 'Segera keluarkan'],
            ['kode_produk' => 'PRD-010', 'nama_produk' => 'Supermi Ayam Bawang', 'kategori' => 'Mie Instan', 'merek' => 'Supermi', 'satuan' => 'karton', 'jumlah_stok' => 110, 'tgl_kadaluarsa' => '2025-12-31', 'keterangan' => null],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}