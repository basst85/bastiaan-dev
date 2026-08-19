<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogReaction extends Model
{
    protected $fillable = ['blog_post_slug', 'reaction'];
}
