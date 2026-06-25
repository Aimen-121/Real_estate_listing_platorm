<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Review;
use App\Models\Booking;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'User_ID';
    public $timestamps = false;

    protected $fillable = [
        'Full_Name',
        'Email',
        'Phone_Number',
        'Identity_Type',
        'Identity_Number',
        'Password',
        'Registration_Date',
        'Status',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    public function getAuthPasswordName()
    {
        return 'Password';
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getAuthIdentifierName()
    {
        return 'User_ID';
    }

    protected function casts(): array
    {
        return [
            'Registration_Date' => 'date',
            'Password' => 'hashed',
        ];
    }

    // Relationships for subtype specialization
    public function admin()
    {
        return $this->hasOne(Admin::class, 'User_ID', 'User_ID');
    }

    public function agent()
    {
        return $this->hasOne(Agent::class, 'User_ID', 'User_ID');
    }

    public function buyer()
    {
        return $this->hasOne(Buyer::class, 'User_ID', 'User_ID');
    }

    public function renter()
    {
        return $this->hasOne(Renter::class, 'User_ID', 'User_ID');
    }

    public function owner()
    {
        return $this->hasOne(Owner::class, 'User_ID', 'User_ID');
    }

    // Role helper methods using loaded relationship checks (prevents redundant queries)
    public function isAdmin(): bool
    {
        return !is_null($this->admin);
    }

    public function isAgent(): bool
    {
        return !is_null($this->agent);
    }

    public function isBuyer(): bool
    {
        return !is_null($this->buyer);
    }

    public function isRenter(): bool
    {
        return !is_null($this->renter);
    }

    public function isOwner(): bool
    {
        return !is_null($this->owner);
    }

    public function getRoles(): array
    {
        $roles = [];
        if ($this->isAdmin()) { $roles[] = 'Admin'; }
        if ($this->isAgent()) { $roles[] = 'Agent'; }
        if ($this->isBuyer()) { $roles[] = 'Buyer'; }
        if ($this->isRenter()) { $roles[] = 'Renter'; }
        if ($this->isOwner()) { $roles[] = 'Owner'; }
        return $roles;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'User_ID', 'User_ID');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'User_ID', 'User_ID');
    }

    // Accessors for Breeze / standard compatibility
    public function getNameAttribute(): ?string
    {
        return $this->attributes['Full_Name'] ?? null;
    }

    public function setNameAttribute(?string $value): void
    {
        $this->attributes['Full_Name'] = $value;
    }

    public function getEmailAttribute(): ?string
    {
        return $this->attributes['Email'] ?? null;
    }

    public function setEmailAttribute(?string $value): void
    {
        $this->attributes['Email'] = $value;
    }

    public function getPasswordAttribute(): ?string
    {
        return $this->attributes['Password'] ?? null;
    }

    public function setPasswordAttribute(?string $value): void
    {
        $this->attributes['Password'] = $value;
    }

    public function getEmailVerifiedAtAttribute()
    {
        return now();
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        // No-op
    }

    // Override remember token to avoid DB column errors
    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // No-op
    }

    public function getRememberTokenName()
    {
        return '';
    }

    public function save(array $options = [])
    {
        unset($this->attributes['remember_token']);
        unset($this->attributes['email_verified_at']);
        return parent::save($options);
    }
}
