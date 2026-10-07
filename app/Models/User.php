<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'rt',
        'rw',
        'phone',
        'jabatan',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Peran / Role Helper Functions
    public function isKades(): bool
    {
        return $this->role === 'kades';
    }

    public function isRtRw(): bool
    {
        return $this->role === 'rt_rw';
    }

    public function isKader(): bool
    {
        return $this->role === 'kader';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'kades' => 'Kepala Desa',
            'rt_rw' => 'Ketua RT ' . ($this->rt ?? '-') . ' / RW ' . ($this->rw ?? '-'),
            'kader' => 'Kader Posyandu',
            default => 'Masyarakat Umum'
        };
    }

    public function getRoleBadgeClassAttribute(): string
    {
        return match ($this->role) {
            'kades' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'rt_rw' => 'bg-blue-100 text-blue-800 border-blue-300',
            'kader' => 'bg-amber-100 text-amber-800 border-amber-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300'
        };
    }

    // Policy helper: Cek apakah user punya hak akses ke wilayah RT/RW tertentu
    public function canAccessWilayah(?string $rt, ?string $rw): bool
    {
        if ($this->isKades()) {
            return true; // Kades memiliki hak akses seluruh desa
        }

        if ($this->isRtRw()) {
            // RT/RW hanya berhak di wilayah RT/RW mereka
            if (!empty($this->rt) && !empty($rt) && $this->rt !== $rt) {
                return false;
            }
            if (!empty($this->rw) && !empty($rw) && $this->rw !== $rw) {
                return false;
            }
            return true;
        }

        return false;
    }

    // Relationships
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function penduduksDibuat()
    {
        return $this->hasMany(Penduduk::class, 'created_by_user_id');
    }

    public function stuntingsDicatat()
    {
        return $this->hasMany(Stunting::class, 'kader_id');
    }
}
