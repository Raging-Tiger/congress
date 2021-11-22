<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'user_events';

    protected $fillable = [
        'user_id',
        'event_id',
    ];
    public function events() {
        return $this->belongsTo(Event::class, 'event_id');
    }  
    
    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
