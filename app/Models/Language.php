<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    public function generalNotifications(){
        return $this->hasMany(Notification::class);
    }
}
