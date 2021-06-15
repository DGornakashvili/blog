<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Storage;

/**
 * Class News
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $gallery_id
 * @property string $slug
 * @property string $header
 * @property string $content
 * @property string $preview
 * @property string $main_image
 */
class News extends BaseModel
{
    /**
     * @inheritdoc
     */
    protected $table = 'news';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'slug',
        'header',
        'content',
        'main_image',
    ];

    public static function getByQuery(Builder $builder)
    {
        return $builder->get();
    }

    /**
     * @return string
     */
    public function getPreviewAttribute(): string
    {
        return Storage::url($this->main_image);
    }
}
