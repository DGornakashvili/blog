<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory(1)->create();
        Tag::factory(20)->create();
        News::factory(10)->create();
        Gallery::factory(10)->create();
        $this->seedGalleryTag();
    }

    /**
     * @return void
     */
    protected function seedGalleryTag(): void
    {
        $tags = Tag::all();
        $galleries = Gallery::all();

        foreach ($galleries as $gallery) {
            /** @var Gallery $gallery */
            $gallery->tags()->sync($tags->random(2)->pluck('id'));
        }
    }
}
