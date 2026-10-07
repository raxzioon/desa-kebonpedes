<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PindahWarga extends Model
{
    use HasFactory;

    protected $table = 'pindah_wargas';

    protected $fillable = [
        'penduduk_id',
        'no_surat_pengantar',
        'alamat_tujuan',
        'rt_tujuan',
        'rw_tujuan',
        'desa_kelurahan_tujuan',
        'kecamatan_tujuan',
        'kabupaten_kota_tujuan',
        'provinsi_tujuan',
        'alasan_pindah',
        'tanggal_pindah',
        'jumlah_keluarga_pindah',
        'status_pengajuan',
        'catatan_kades',
        'diajukan_oleh_user_id',
        'disetujui_oleh_user_id',
        'disetujui_at',
    ];

    protected $casts = [
        'tanggal_pindah' => 'date',
        'disetujui_at' => 'datetime',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function diajukanOleh()
    {
        return $this->belongsTo(User::class, 'diajukan_oleh_user_id');
    }

    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh_user_id');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status_pengajuan) {
            'menunggu' => ['class' => 'bg-amber-100 text-amber-800 border-amber-300', 'label' => 'Menunggu Persetujuan Kades'],
            'disetujui' => ['class' => 'bg-emerald-100 text-emerald-800 border-emerald-300', 'label' => 'Disetujui Kades'],
            'ditolak' => ['class' => 'bg-rose-100 text-rose-800 border-rose-300', 'label' => 'Ditolak'],
            default => ['class' => 'bg-slate-100 text-slate-800 border-slate-300', 'label' => $this->status_pengajuan],
        };
    }
}
