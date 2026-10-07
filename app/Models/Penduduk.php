<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduks';

    protected $fillable = [
        'nik',
        'no_kk',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_pernikahan',
        'golongan_darah',
        'rt',
        'rw',
        'alamat',
        'status_dasar',
        'opt_in_persetujuan',
        'opt_in_at',
        'created_by_user_id',
        'updated_by_user_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'opt_in_persetujuan' => 'boolean',
        'opt_in_at' => 'datetime',
    ];

    // Helper Etika Profesi & PDP: Masking NIK (contoh: 320214******0001)
    public function getMaskedNikAttribute(): string
    {
        if (strlen($this->nik) >= 16) {
            return substr($this->nik, 0, 6) . '******' . substr($this->nik, -4);
        }
        return '3202********0001';
    }

    public function getMaskedNoKkAttribute(): string
    {
        if (strlen($this->no_kk) >= 16) {
            return substr($this->no_kk, 0, 6) . '******' . substr($this->no_kk, -4);
        }
        return '3202********0001';
    }

    // Usia dihitung dinamis dari tanggal lahir
    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : 0;
    }

    public function getKategoriUsiaAttribute(): string
    {
        $usia = $this->usia;
        if ($usia <= 5) return 'Balita (0-5 th)';
        if ($usia <= 12) return 'Anak-anak (6-12 th)';
        if ($usia <= 18) return 'Remaja (13-18 th)';
        if ($usia <= 59) return 'Dewasa (19-59 th)';
        return 'Lansia (60+ th)';
    }

    // Scope query untuk membatasi data berdasarkan RT/RW user yang login
    public function scopeWilayah($query, ?User $user = null)
    {
        $user = $user ?? auth()->user();
        if (!$user) {
            return $query;
        }

        if ($user->isKades()) {
            return $query; // Kades bisa melihat semua wilayah
        }

        if ($user->isRtRw()) {
            if ($user->rt) {
                $query->where('rt', $user->rt);
            }
            if ($user->rw) {
                $query->where('rw', $user->rw);
            }
            return $query;
        }

        return $query;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function riwayatPindah()
    {
        return $this->hasMany(PindahWarga::class, 'penduduk_id');
    }

    public function catatanKematian()
    {
        return $this->hasOne(KematianWarga::class, 'penduduk_id');
    }
}
