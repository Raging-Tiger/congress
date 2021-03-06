<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillStatus extends Model
{
    use HasFactory;
    
    
    public $timestamps = false;
    
    /* Eloquent relations definition */
    
    public function bills(){
        return $this->hasMany(Bill::class);
    }
}
