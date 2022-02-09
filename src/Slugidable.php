<?php

namespace Josezenem\Slugidable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

trait Slugidable
{
    protected array $slugidableSettings = [];

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

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootSlugidable()
    {
        static::saving(function ($model) {
            $model->slug = $model->getSlugidableSlug();
        });

        static::saved(function($model) {
            if(Str::startsWith($model->slug, [':t', ':u']))
            {
                $model->updateQuietly(['slug' => $model->getSlugidableSlug()]);
            }
        });
    }

    protected function getSlugidableSlug(): UuidInterface|string
    {
        $this->configureSlugidableSettings();

        $using_key_name = $this->slugidableSettings['using_key_name'];

        $slug_to = $this->getAttribute($this->slugidableSettings['slug_to']);
        $slug_from = $this->getAttribute($this->slugidableSettings['slug_from']);

        if($this->getAttribute($using_key_name))
        {
            if(Str::startsWith($slug_to, ':u') !== false)
            {
                $preffered_slug = $slug_from;
            }
            else if(Str::startsWith($slug_to, ':t') !== false) {
                $preffered_slug = substr($slug_to, 2);
            }
            else
            {
                $preffered_slug = $slug_from;
            }

            if($this->slugidableSettings['on'] === 'prefix')
            {
                $slug = Str::start(Str::slug($preffered_slug, $this->slugidableSettings['using_separator']), $this->getAttribute($using_key_name) . $this->slugidableSettings['using_separator']);
            }
            else
            {
                $slug = Str::finish(Str::slug($preffered_slug, $this->slugidableSettings['using_separator']), $this->slugidableSettings['using_separator'] . $this->getAttribute($using_key_name));
            }
        }
        elseif($slug_to)
        {
            $slug = ':t' . $slug_to;
        }
        else
        {
            $slug = ':u' . Str::uuid()->toString();
        }

        return $slug;
    }

    /**
     * Scope a query to search based on the KeyName only
     *
     * @param  Builder  $query
     * @param  string  $slug
     * @return Builder
     */
    public function scopeFromSlugidable($query, $slug)
    {
        $this->configureSlugidableSettings();

        if($this->slugidableSettings['using_separator'] === 'prefix')
        {
            $slug_id = strstr($slug, $this->slugidableSettings['using_separator'], true);
        }
        else
        {
            $slug_id = substr(strrchr($slug, $this->slugidableSettings['using_separator']), 1);
        }

        $query->where($this->slugidableSettings['using_key_name'], $slug_id);
    }
}
