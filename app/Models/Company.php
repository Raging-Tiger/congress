<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'country',
    ];

    public $timestamps = false;
    
    /* Eloquent relations definition */
    
    public function users(){
        return $this->hasMany(User::class);
    }
    
}
