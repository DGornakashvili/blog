<?php

namespace App\Services\Models;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Services\FilterService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Str;

class NewsService
{
    /**
     * @param Request $request
     *
     * @return Collection
     */
    public static function getResponse(Request $request): Collection
    {
        return News::getByQuery(FilterService::setAll((new News()), $request));
    }

    /**
     * @param int $id
     * @param NewsRequest $request
     *
     * @return bool
     */
    public static function manageUpdate(int $id, NewsRequest $request): bool
    {
        $result = true;
        /** @var News $news */
        $news = News::query()->findOrFail($id);
        $news->fill($request->validated());

        if (!$request->has('slug') || !$request->get('slug')) {
            $news->slug = Str::slug($news->header);
        }

        if ($news->isDirty()) {
            $result = $news->save();
        }

        return $result;
    }

    /**
     * @param NewsRequest $request
     *
     * @return bool
     */
    public static function manageCreate(NewsRequest $request): bool
    {
        /** @var News $news */
        $news = News::query()->create(array_merge(
            $request->validated(), ['slug' => Str::slug($request->header)]
        ));

        return (bool)$news->getAttribute('id');
    }
}
