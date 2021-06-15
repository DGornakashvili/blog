<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * Class GalleryFactory
 *
 * @package Database\Factories
 */
class GalleryFactory extends Factory
{
    /**
     * @inheritdoc
     */
    protected $model = Gallery::class;

    /**
     * @inheritdoc
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'description' => Str::random(30),
            'img' => last(explode('/', $this->faker->image(
                config('filesystems.disks.public.root')
            ))),
        ];
    }
}
