<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleStatus extends Model
{
    use HasFactory;
    
    protected $table = 'article_statuses';
    
    public $timestamps = false;
    
    public function articles(){
        return $this->hasMany(Article::class);
    }
}
