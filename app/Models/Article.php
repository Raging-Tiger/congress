<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function articleStatuses(){
        return $this->belongsTo(ArticleStatus::class);
    }
    
    public function users() {
        return $this->belongsTo(User::class);
    }  
    
    public function events() {
        return $this->belongsTo(Event::class);
    } 

}
