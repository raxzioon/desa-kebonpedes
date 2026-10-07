<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatans';

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'lokasi',
        'tanggal_kegiatan',
        'jam_kegiatan',
        'kuota_relawan',
        'kontak_pj',
        'no_wa_pj',
        'foto',
        'status',
        'created_by_user_id',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];

    public function relawans()
    {
        return $this->hasMany(RelawanKegiatan::class, 'kegiatan_id');
    }

    public function getJumlahRelawanAttribute(): int
    {
        return $this->relawans()->count();
    }

    public function getSisaKuotaAttribute(): int
    {
        return max(0, $this->kuota_relawan - $this->jumlah_relawan);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'Akan Datang' => ['class' => 'bg-emerald-100 text-emerald-800 border-emerald-300', 'label' => 'Akan Datang'],
            'Berlangsung' => ['class' => 'bg-blue-100 text-blue-800 border-blue-300', 'label' => 'Sedang Berlangsung'],
            'Selesai' => ['class' => 'bg-slate-100 text-slate-700 border-slate-300', 'label' => 'Telah Selesai'],
            default => ['class' => 'bg-slate-100 text-slate-700', 'label' => $this->status],
        };
    }
}
