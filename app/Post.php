<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['body','user_id','room_id'];

    public function user () 
    {
        return $this->belongsTo(User::class);
    }

    public function room () 
    {
        return $this->belongsTo(Room::class);
    }

}