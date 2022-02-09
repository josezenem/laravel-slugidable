<?php

use Illuminate\Support\Str;
use Josezenem\Slugidable\Tests\Dummy\Blog;

it('can use custom slug during create', function () {

    $custom_slug = 'i am a custom slug';

    $model = Blog::create(['title' => 'hello', 'slug' => $custom_slug]);

    expect($model->slug)->toBe(Str::slug($custom_slug . ' ' . $model->id));
});

it('create custom slug if no slug is present', function () {

    $title = 'i am a title';

    $model = Blog::create(['title' => $title]);

    expect($model->slug)->toBe(Str::slug($title . ' ' . $model->id));
});

it('can find model from slugidable', function () {

    $title = 'find this article based on an id';
    $another_title = 'Another articled based on an ID';

    $blog1 = Blog::create(['title' => $title]);
    $blog2 = Blog::create(['title' => $another_title]);

    $find_blog1 = Blog::fromSlugidable($blog1->slug)->get();
    $find_blog2 = Blog::fromSlugidable($blog2->slug)->first();

    expect($find_blog1->count())->toEqual(1);

    expect($find_blog2->slug)->toBe($blog2->slug);

});
