# Slugidable Generate slugs based on title and ID

[![Latest Stable Version](http://poser.pugx.org/josezenem/laravel-slugidable/v)](https://packagist.org/packages/josezenem/laravel-slugidable)
[![Tests](https://github.com/josezenem/laravel-slugidable/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/josezenem/laravel-slugidable/actions/workflows/run-tests.yml)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/0a99e65b8c004592b411bee8710fba1a)](https://www.codacy.com/gh/josezenem/laravel-slugidable/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=josezenem/laravel-slugidable&amp;utm_campaign=Badge_Grade)
[![Total Downloads](https://img.shields.io/packagist/dt/josezenem/laravel-slugidable.svg?style=flat-square)](https://packagist.org/packages/josezenem/laravel-slugidable)

A package for Laravel that creates slugs for Eloquent models based on both a title and ID

Compatible with Laravel 8, Laravel 9

```php
$model = new Blog();
$model->title = 'Dwight jumped over the fence';
$model->save();

echo $model->slug; // output: dwight-jumped-over-the-fence-012422
```

All settings are fully configurable for each model.

## Installation

You can install the package via composer:

```bash
composer require josezenem/laravel-slugidable
```

## Usage

Simply `Josezenem\Slugidable\Slugidable` trait to your model.

```php
// App\Models\Blog
<?php

use Josezenem\Slugidable\HasSlugidable;

class Blog extends Model {
    use HasSlugidable;
    
    protected $fillable = [
        'title',
        'slug',
    ];
}

$blog = create([
    'title' => 'My dog Dwight jumped over the fence',
])

// When this is created, it will make the slug of
//my-dog-dwight-jumped-over-the-fence-1
```

We have included a handy scope method: **fromSlugidable()** that will extract the ID from the slug and search the model

```php
$blog = Blog::fromSlugidable('my-dog-dwight-012422')->first();

// in this scenario only ID: 012422 is used inside the scope to find the slug.

```

#### Configuration

By default we use id, title, slug columns from the model, but you can override these settings by adding the following method to your model.

```php
protected function configureSlugidableSettings():void
{
    $this->slugidableSettings = [
        'slug_from' => 'title',
        'slug_to' => 'slug',
        'using_key_name' => $this->getKeyName(),
        'on' => 'suffix',
        'using_separator' => '-',
        'force_slug_from' => false,
    ];
}
```
* **slug_from** is where the slug will grab the the slug from
* **slug_to** the place where the slug lives
* **using_key_name** the ID field used to prefix or suffix the ID
* **on** could be "prefix" to have the ID before the slug text, or "suffix" to have it after.
* **using_separator** the seperator to use during slug creation
* **force_slug_from** force the system to always slug from 'slug_from' regardless if `slug_to` is present


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jose Jimenez](https://github.com/josezenem)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
