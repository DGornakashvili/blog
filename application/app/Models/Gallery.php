<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Gallery
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $uuid
 * @property string $img
 * @property string $description
 * @property Collection $tags
 */
class Gallery extends BaseModel
{
    /**
     * @inheritdoc
     */
    protected $fillable = [
        'img',
        'description',
    ];

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @param Builder $builder
     * @return Collection
     */
    public static function getByQuery(Builder $builder): Collection
    {
        return $builder->get();
    }

}
