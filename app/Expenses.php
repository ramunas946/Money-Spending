<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $fillable = [
        'user_id','expenses','money','goal'
    ];
    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
