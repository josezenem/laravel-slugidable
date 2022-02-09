# This is my package laravel-slugidable

This will allow you to create slugs with the ID as part of the slug.  It will utilize the "title" if no slug is passed, or use the slug if one is set during your create.

For example: domain.com/my-dog-dwight-jumped-over-the-fence-012422

* **my-dog-dwight-jumped-over-the-fence** being the string
* **012422** being the ID

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

use Josezenem\Slugidable\Slugidable;

class Blog extends Model {
    use Slugidable;
    
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
    ];
}
```
* **slug_from** is where the slug will grab the the slug from
* **slug_to** the place where the slug lives
* **using_key_name** the ID field used to prefix or suffix the ID
* **on** could be "prefix" to have the ID before the slug text, or "suffix" to have it after.
* **using_separator** the seperator to use during slug creation


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
