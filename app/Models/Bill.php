<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_cost_per_articles',
        'total_cost_per_participation',
        'total_cost_per_materials',
        'user_id',
        'event_id',
        'bill_status_id',
    ];
    
    public function billStatuses(){
        return $this->belongsTo(BillStatus::class, 'bill_status_id');
    }
    
    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    } 
    
    public function events() {
        return $this->belongsTo(Event::class, 'event_id');
    } 
}
