<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleriesRequest;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\GalleriesResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\TagsResource;
use App\Models\Tag;
use App\Services\Models\GalleryService;
use App\Services\Models\NewsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('index');
    }

    /**
     * @param GalleriesRequest $request
     *
     * @return JsonResponse
     */
    public function galleries(GalleriesRequest $request): JsonResponse
    {
        return GalleriesResource::collection(
            GalleryService::getResponse($request)
        )->response();
    }

    /**
     * @param NewsRequest $request
     *
     * @return JsonResponse
     */
    public function news(NewsRequest $request): JsonResponse
    {
        return NewsResource::collection(
            NewsService::getResponse($request)
        )->response();
    }

    /**
     * @return JsonResponse
     */
    public function tags(): JsonResponse
    {
        return TagsResource::collection(Tag::all())->response();
    }
}
