<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkms';

    protected $fillable = [
        'nama_usaha',
        'nama_pemilik',
        'nomor_wa',
        'kategori',
        'nama_produk',
        'deskripsi',
        'harga',
        'satuan',
        'lokasi_pasar',
        'foto',
        'rt',
        'rw',
        'is_tersedia_di_pasar',
        'is_aktif',
        'user_id',
    ];

    protected $casts = [
        'harga' => 'float',
        'is_tersedia_di_pasar' => 'boolean',
        'is_aktif' => 'boolean',
    ];

    // Format Rupiah
    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Link WhatsApp langsung dengan pesan otomatis
    public function getWaLinkAttribute(): string
    {
        $nomor = preg_replace('/[^0-9]/', '', $this->nomor_wa);
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        $pesan = urlencode("Halo Bapak/Ibu {$this->nama_pemilik}, saya melihat produk '{$this->nama_produk}' di Website Resmi Desa Kebonpedes. Apakah produk ini masih tersedia?");
        return "https://wa.me/{$nomor}?text={$pesan}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
