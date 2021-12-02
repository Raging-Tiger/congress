<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'is_visible',
        'start_date',
        'end_date',
        'registration_until',
        'info',
        'event_type_id',
        'billing_plan_id',
    ];
    
    public function eventTypes(){
        return $this->belongsTo(EventType::class, 'event_type_id');
    }
    
    
    public function billingPlans(){
        return $this->belongsTo(BillingPlan::class, 'billing_plan_id');
    }
    
    public function userEvents(){
        return $this->hasMany(UserEvent::class);
    }
    
    public function materials(){
        return $this->hasMany(Material::class);
    }
    
    public function bills(){
        return $this->hasMany(Bill::class);
    }
    
    public function articles(){
        return $this->hasMany(Article::class, 'event_id');
    }
    
    
    public function article_curr($id){
        return (Article::where('event_id', '=', $this->id)
                ->where('user_id', '=', $id)->first());

    }
    
    public function isRegistred($id){
        return (UserEvent::where('event_id', '=', $this->id)
                ->where('user_id', '=', $id)->exists());

    }
    
}
