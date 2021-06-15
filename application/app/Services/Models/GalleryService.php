<?php

namespace App\Services\Models;

use App\Http\Requests\GalleriesRequest;
use App\Models\Gallery;
use App\Services\FilterService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Str;

class GalleryService
{
    /**
     * @param Request $request
     *
     * @return Collection
     */
    public static function getResponse(Request $request): Collection
    {
        return Gallery::getByQuery(FilterService::setTag(Gallery::query(), $request));
    }

    /**
     * @param int $id
     * @param GalleriesRequest $request
     *
     * @return bool
     */
    public static function manageUpdate(int $id, GalleriesRequest $request): bool
    {
        $result = true;
        /** @var Gallery $gallery */
        $gallery = Gallery::with('tags')->findOrFail($id);
        $gallery->fill($request->validated());

        if ($gallery->isDirty()) {
            $result = $gallery->save();
        }

        if ($gallery->tags->pluck('id')->toArray() != $request->tags) {
            $gallery->tags()->detach($gallery->tags);
            $gallery->tags()->sync($request->tags);
        }

        return $result;
    }

    /**
     * @param GalleriesRequest $request
     *
     * @return bool
     */
    public static function manageCreate(GalleriesRequest $request): bool
    {
        $gallery = new Gallery();
        $gallery->fill($request->validated());
        $gallery->uuid = Str::uuid()->toString();
        $result = $gallery->save();
        $gallery->tags()->sync($request->tags);

        return $result;
    }
}
