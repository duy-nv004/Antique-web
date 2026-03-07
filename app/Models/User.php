<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'phone_number',      // Khớp với migration của Duy
        'phone_verified_at',
        'otp_code',          // Mã OTP xác thực
        'otp_expires_at',    // Thời gian hết hạn OTP
        'is_active',         // Trạng thái tài khoản (true/false)
        'is_admin',          // Quyền quản trị (true/false)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
        ];
    }
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Quan hệ: Một User có thể có nhiều đơn hàng (nếu bạn làm bảng orders).
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
