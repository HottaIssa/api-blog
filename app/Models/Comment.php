<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = 'comments';
    public $fillable = [
        "post_id",
        "user_id",
        "comment"
    ];
}
