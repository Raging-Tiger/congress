<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    
    
    public function billStatuses(){
        return $this->belongsTo(BillStatus::class);
    }
    
    public function users() {
        return $this->belongsTo(User::class);
    } 
    
    public function events() {
        return $this->belongsTo(Event::class);
    } 
}
