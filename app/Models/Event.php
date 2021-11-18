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
        return $this->hasMany(Article::class);
    }
    
}
