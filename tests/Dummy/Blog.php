<?php

namespace Josezenem\Slugidable\Tests\Dummy;

use Illuminate\Database\Eloquent\Model;
use Josezenem\Slugidable\HasSlugidable;

class Blog extends Model
{
    use HasSlugidable;

    protected $fillable = [
        'title',
        'slug',
    ];
}
