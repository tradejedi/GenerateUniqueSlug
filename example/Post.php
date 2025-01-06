<?php

use TradeJedi\Traits\GeneratesSlug;

class Post extends Model
{
    use GeneratesSlug;

    protected $fillable = ['title', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ( isset($model->title) && empty($model->slug)) {
                $model->slug = self::generateUniqueSlug($model->title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = self::generateUniqueSlug($model->title, 'slug', $model->id);
            }
        });
    }
}
