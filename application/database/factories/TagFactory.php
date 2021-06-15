<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * Class TagFactory
 *
 * @package Database\Factories
 */
class TagFactory extends Factory
{
    /**
     * @inheritdoc
     */
    protected $model = Tag::class;

    /**
     * @inheritdoc
     */
    public function definition(): array
    {
        return [
            'name' => '#' . Str::random(5),
        ];
    }
}
