<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'stau',
        'is_vf',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';
    const ROLE_CUSTOMER = 'customer';
    const ROLE_AFFILIATE = 'affiliate';

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    public function isAffiliate(): bool
    {
        return $this->role === self::ROLE_AFFILIATE;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_vf' => 'boolean',
            'stau' => 'integer',
        ];
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function staffProfile(): HasOne
    {
        return $this->hasOne(StaffProfile::class, 'user_id');
    }

    public function affiliateProfile(): HasOne
    {
        return $this->hasOne(Affiliate::class, 'user_id');
    }

    public function customerProfile(): HasOne
    {
        return $this->hasOne(CustomerProfile::class, 'user_id');
    }
}
