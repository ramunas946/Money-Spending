<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graphs extends Model
{
    protected $fillable = [
        'user_id','money'
    ];
    public function user()
    {
        return $this->belongsTo("App\User");
    }
    public function income()
    {
        return $this->hasMany("App\income");
    }
}
