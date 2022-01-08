<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'header',
        'message',
        'user_id',
        'notification_type_id',
        'language_id',
    ];
    
    /* Eloquent relations definition */
    
    public function languages(){
        return $this->belongsTo(Language::class, 'language_id');
    }
    
    public function notificationTypes(){
        return $this->belongsTo(NotificationType::class, 'notification_type_id');
    }
    
    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
