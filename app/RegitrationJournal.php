<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegitrationJournal extends Model
{
    protected $connection = 'mysql'; // choose db connection
    protected $table = 'tbl0'; //choose table

    public function scopeAnswer($query, $value)
    {
        return $query->where('clientcode',$value);
    }
    public function scopeShown($query)
    {
        return $query->where('is_show','Y');
    }
}
