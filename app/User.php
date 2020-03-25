<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'manager',
        'seller'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'user', 'id');
    }

    public function scopeManagers($query)
    {
        return $query->where('manager', true);
    }

    public function scopeSellers($query)
    {
        return $query->where('seller', true);
    }

    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            unset($this->attributes['password']);
            return;
        }

        $this->attributes['password'] = bcrypt($value);
    }

    public function setManagerAttribute($value)
    {
        $this->attributes['manager'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setSellerAttribute($value)
    {
        $this->attributes['seller'] = ($value === true || $value === 'on' ? 1 : 0);
    }
}
