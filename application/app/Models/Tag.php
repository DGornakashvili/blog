<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Tag
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property Collection $galleries
 */
class Tag extends BaseModel
{
    /**
     * @inheritdoc
     */
    protected $fillable = ['name'];

    /**
     * @return BelongsToMany
     */
    public function galleries(): BelongsToMany
    {
        return $this->belongsToMany(Gallery::class);
    }
}
