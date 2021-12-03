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
    
    /* Eloquent relations definition */
    public function roles(){
        return $this->belongsTo(Role::class, 'role_id');
    }
    
    
    public function fullNames(){
        return $this->belongsTo(Name::class, 'name_id');
    }
    
    
    public function companies(){
        return $this->belongsTo(Company::class, 'company_id');
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
    
   /* Roles checking requests */
    public function isAdmin() {
        return ($this->role_id == 1);
    } 
    
    public function isBlocked() {
        return ($this->role_id == 5);
    } 
    
    public function isPrivate() {
        return ($this->role_id == 2);
    } 
    
    public function isReviewer() {
        return ($this->role_id == 4);
    }
    
    public function isCommercial() {
        return ($this->role_id == 3);
    } 
    
    public function isParticipant() {
        return ($this->role_id == 2 || $this->role_id == 3);
    } 
    
    /* Registration for current event checking request */
    public function isRegistred($id) {
        return (UserEvent::where('event_id', '=', $id)->where('user_id', '=', $this->id)->exists());
    }
    
        
    public function isPaidArticle($eventId) {
        return (Bill::where('event_id', '=', $eventId)
                ->where('user_id', '=', $this->id)
                ->where('bill_status_id', '=', 2)
                ->where('total_cost_per_articles', '!=', NULL)
                ->exists());
    }
    
    public function isArticleService($eventId) {
        return (Bill::where('event_id', '=', $eventId)
                ->where('user_id', '=', $this->id)
                ->where('bill_status_id', '!=', 2)
                ->where('total_cost_per_articles', '!=', NULL)
                ->exists());
    }
    
    public function hasArticle($eventId) {
        return (Article::where('event_id', '=', $eventId)
                ->where('user_id', '=', $this->id)
                ->exists());
    }
    
    public function billEvent($eventId){

        return (Bill::where('event_id', '=', $eventId)
                ->where('user_id', '=', $this->id)
                ->first());

    }
}
