<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelawanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'relawan_kegiatans';

    protected $fillable = [
        'kegiatan_id',
        'nama_relawan',
        'no_wa',
        'rt',
        'rw',
        'pesan_dukungan',
        'status_kehadiran',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
}
