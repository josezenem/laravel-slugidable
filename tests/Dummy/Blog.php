<?php

namespace Josezenem\Slugidable\Tests\Dummy;

use Illuminate\Database\Eloquent\Model;
use Josezenem\Slugidable\Slugidable;

class Blog extends Model
{
    use Slugidable;

    protected $fillable = [
        'title',
        'slug',
    ];
}
