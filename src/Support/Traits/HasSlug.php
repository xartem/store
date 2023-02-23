<?php

namespace Support\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function (Model $model) {
            $model->slug = $model->getUniqueSlug();
        });
    }

    protected function getUniqueSlug(int $increment = 0): string
    {
        $slug = $this->slug ?? str($this->{$this->slugFrom()})->slug();

        if ($increment) {
            $slug .= '-'.$increment;
        }

        if ($count = $this->query()->where('slug', $slug)->count() > 0) {
            $slug = $this->getUniqueSlug(++$count);
        }

        return $slug;
    }

    protected function slugFrom(): string
    {
        return 'title';
    }
}
