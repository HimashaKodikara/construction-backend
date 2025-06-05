<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected function casts(): array{
        return [
            'created_at' => 'datetime:d M, Y',
        ];
    }
}
