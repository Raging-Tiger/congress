<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'name_id',
        'company_id',
        'email_notifications'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function roles(){
        return $this->belongsTo(Role::class);
    }
    
    
    public function names(){
        return $this->belongsTo(Role::class);
    }
    
    
    public function companies(){
        return $this->belongsTo(Role::class);
    }
    
    public function generalNotifications(){
        return $this->hasMany(Notification::class);
    }
    
    public function userEvents(){
        return $this->hasMany(UserEvent::class);
    }
    
    public function articles(){
        return $this->hasMany(Article::class);
    }
    
    public function materials(){
        return $this->hasMany(Material::class);
    }
    
    public function bills(){
        return $this->hasMany(Bill::class);
    }
    
   
    public function isAdmin() {
        return ($this->role_id == 1);
    } 
    
    public function isBlocked() {
        return ($this->role_id == 5);
    } 
}
