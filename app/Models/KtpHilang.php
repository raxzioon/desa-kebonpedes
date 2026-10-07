<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KtpHilang extends Model
{
    use HasFactory;

    protected $table = 'ktp_hilangs';

    protected $fillable = [
        'kode_lacak',
        'nik_pemohon',
        'nama_pemohon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'no_hp',
        'alamat',
        'rt',
        'rw',
        'lokasi_kehilangan',
        'tanggal_kehilangan',
        'kronologi',
        'berkas_kk',
        'berkas_surat_polisi',
        'status',
        'catatan_rt',
        'verified_rt_by',
        'verified_rt_at',
        'catatan_kades',
        'approved_kades_by',
        'approved_kades_at',
        'no_surat_keterangan',
        'tgl_surat_keterangan',
        'opt_in_persetujuan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_kehilangan' => 'date',
        'tgl_surat_keterangan' => 'date',
        'verified_rt_at' => 'datetime',
        'approved_kades_at' => 'datetime',
        'opt_in_persetujuan' => 'boolean',
    ];

    public function getMaskedNikAttribute(): string
    {
        if (strlen($this->nik_pemohon) >= 16) {
            return substr($this->nik_pemohon, 0, 6) . '******' . substr($this->nik_pemohon, -4);
        }
        return '3202********0001';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'diajukan' => '1. Menunggu Verifikasi RT',
            'verifikasi_rt' => '2. Terverifikasi RT (Menunggu Kades)',
            'disetujui_kades' => '3. Disetujui Kepala Desa',
            'selesai' => '4. Surat Keterangan Selesai',
            'ditolak' => 'Pengajuan Ditolak',
            default => ucfirst($this->status)
        };
    }

    public function getStatusStepAttribute(): int
    {
        return match ($this->status) {
            'diajukan' => 1,
            'verifikasi_rt' => 2,
            'disetujui_kades' => 3,
            'selesai' => 4,
            'ditolak' => 0,
            default => 1
        };
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'diajukan' => ['class' => 'bg-amber-100 text-amber-800 border-amber-300', 'icon' => 'clock', 'text' => 'Diajukan Warga'],
            'verifikasi_rt' => ['class' => 'bg-blue-100 text-blue-800 border-blue-300', 'icon' => 'shield-check', 'text' => 'Diverifikasi RT'],
            'disetujui_kades' => ['class' => 'bg-emerald-100 text-emerald-800 border-emerald-300', 'icon' => 'check-badge', 'text' => 'Disetujui Kades'],
            'selesai' => ['class' => 'bg-teal-100 text-teal-800 border-teal-300', 'icon' => 'document-check', 'text' => 'Surat Siap Diambil/Unduh'],
            'ditolak' => ['class' => 'bg-rose-100 text-rose-800 border-rose-300', 'icon' => 'x-circle', 'text' => 'Ditolak'],
            default => ['class' => 'bg-slate-100 text-slate-800 border-slate-300', 'icon' => 'information-circle', 'text' => $this->status],
        };
    }

    public function verifiedRtBy()
    {
        return $this->belongsTo(User::class, 'verified_rt_by');
    }

    public function approvedKadesBy()
    {
        return $this->belongsTo(User::class, 'approved_kades_by');
    }
}
