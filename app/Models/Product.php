<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasTags;
    public function registerAllMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('cover')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->width(300)
            ->height(300)
            ->sharpen(10);
    }
}
