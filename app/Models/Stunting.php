<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stunting extends Model
{
    use HasFactory;

    protected $table = 'stuntings';

    protected $fillable = [
        'nama_anak',
        'nik_anak',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_ibu',
        'nama_ayah',
        'rt',
        'rw',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'status_gizi',
        'status_stunting',
        'tanggal_pemeriksaan',
        'posyandu_nama',
        'catatan_kader',
        'intervensi_diberikan',
        'kader_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pemeriksaan' => 'date',
        'berat_badan' => 'float',
        'tinggi_badan' => 'float',
        'lingkar_kepala' => 'float',
    ];

    // Hitung usia dalam bulan
    public function getUsiaBulanAttribute(): int
    {
        if (!$this->tanggal_lahir) return 0;
        $tglCek = $this->tanggal_pemeriksaan ?? now();
        return (int) $this->tanggal_lahir->diffInMonths($tglCek);
    }

    public function getMaskedNikAnakAttribute(): string
    {
        if (empty($this->nik_anak)) return '-';
        if (strlen($this->nik_anak) >= 16) {
            return substr($this->nik_anak, 0, 6) . '******' . substr($this->nik_anak, -4);
        }
        return '3202********0001';
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status_stunting) {
            'Sangat Pendek (Severely Stunted)' => [
                'class' => 'bg-rose-100 text-rose-800 border-rose-300',
                'icon' => 'exclamation-triangle',
                'label' => 'Sangat Pendek (Stunting Berat)',
            ],
            'Pendek (Stunted)' => [
                'class' => 'bg-amber-100 text-amber-800 border-amber-300',
                'icon' => 'exclamation-circle',
                'label' => 'Pendek (Perlu Intervensi)',
            ],
            'Tinggi' => [
                'class' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
                'icon' => 'arrow-trending-up',
                'label' => 'Tinggi',
            ],
            default => [
                'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                'icon' => 'check-circle',
                'label' => 'Tinggi Normal & Sehat',
            ],
        };
    }

    public function kader()
    {
        return $this->belongsTo(User::class, 'kader_id');
    }
}
