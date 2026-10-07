<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KematianWarga extends Model
{
    use HasFactory;

    protected $table = 'kematian_wargas';

    protected $fillable = [
        'penduduk_id',
        'tanggal_kematian',
        'waktu_kematian',
        'tempat_kematian',
        'sebab_kematian',
        'nama_pelapor',
        'hubungan_pelapor',
        'status_pengajuan',
        'catatan_kades',
        'diajukan_oleh_user_id',
        'disetujui_oleh_user_id',
        'disetujui_at',
    ];

    protected $casts = [
        'tanggal_kematian' => 'date',
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
