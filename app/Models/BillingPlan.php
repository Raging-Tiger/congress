<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingPlan extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $fillable = [
        'name',
        'cost_per_article',
        'cost_per_participation',
        'cost_per_material',

    ];
    public function events(){
        return $this->hasMany(Event::class);
    }
}
