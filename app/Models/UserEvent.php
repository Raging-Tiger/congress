<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    public function events() {
        return $this->belongsTo(Event::class);
    }  
    
    public function users() {
        return $this->belongsTo(User::class);
    }
}
