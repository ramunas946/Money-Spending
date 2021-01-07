<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'user_id','money','month'
    ];
    public function graphs()
    {
        return $this->belongsTo("App\Graphs");
    }
}
