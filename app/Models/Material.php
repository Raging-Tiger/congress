<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'reference',
        'user_id',
        'event_id',
    ];
    
    public $timestamps = false;
    
    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function events() {
        return $this->belongsTo(Event::class, 'event_id');
    } 
}
