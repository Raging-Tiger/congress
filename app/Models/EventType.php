<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'event_types';
    
    /* Eloquent relations definition */
    
    public function events(){
        return $this->hasMany(Event::class);
    }
}
