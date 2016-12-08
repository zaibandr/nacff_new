<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $table = 'LETTERS';

    public function scopeSearch($query, $key){
        return $query->whereIn('ID',$key);
    }
    public function scopeActive($query){
        return $query->where('FLAG',1);
    }
}
