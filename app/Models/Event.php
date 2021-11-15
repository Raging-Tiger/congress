<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    
    public function eventTypes(){
        return $this->belongsTo(EventType::class);
    }
    
    
    public function billingPlans(){
        return $this->belongsTo(BillingPlan::class);
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
