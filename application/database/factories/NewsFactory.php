<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class NewsFactory
 *
 * @package Database\Factories
 */
class NewsFactory extends Factory
{
    /**
     * @inheritdoc
     */
    protected $model = News::class;

    /**
     * @inheritdoc
     */
    public function definition(): array
    {
        $header = $this->getTitle();

        return [
            'header' => $header,
            'slug' => Str::slug($header),
            'content' => Str::random(200),
            'main_image' => last(explode('/', $this->faker->image(
                config('filesystems.disks.public.root')
            ))),
        ];
    }

    /**
     * @return string
     */
    protected function getTitle(): string
    {
        return 'News item ' . rand(1, 1000);
    }
}
