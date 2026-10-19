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
        ];
    }

    public function isKepala(): bool
    {
        return $this->role === 'kepala_cabang';
    }

    public function isAdminAccounting(): bool
    {
        return $this->role === 'admin_accounting';
    }

    public function isAdminEkspedisi(): bool
    {
        return $this->role === 'admin_ekspedisi';
    }

    public function canManageFinance(): bool
    {
        // Hanya Admin Accounting yang bisa akses keuangan & laporan
        return $this->role === 'admin_accounting';
    }

    public function canManageResi(): bool
    {
        // Hanya Admin Ekspedisi yang bisa kelola (CRUD) resi
        return $this->role === 'admin_ekspedisi';
    }

    public function canManageUsers(): bool
    {
        return $this->role === 'kepala_cabang';
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'kepala_cabang'   => 'Kepala Cabang',
            'admin_accounting' => 'Admin Accounting',
            'admin_ekspedisi'  => 'Admin Ekspedisi',
            default           => ucwords(str_replace('_', ' ', $this->role)),
        };
    }

    public function resis()
    {
        return $this->hasMany(Resi::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
