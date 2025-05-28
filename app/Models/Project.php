<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //

    protected $fillable = [
        'id',
        'title',
        'slug',
        'short_desc',
        'content',
        'construction_type',
        'sector',
        'location',
        'image',
        'status',
    ];


}
