<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleriesRequest;
use App\Models\Gallery;
use App\Services\FileService;
use App\Services\Models\GalleryService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class GalleriesController
 *
 * @package App\Http\Controllers
 */
class GalleriesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('admin.galleries.index');
    }

    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        return response()->json(['data' => Gallery::all(['id', 'description'])]);
    }

    /**
     * @param int $id
     *
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        return view('admin.galleries.edit', ['id' => $id]);
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('admin.galleries.create');
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        /** @var Gallery $gallery */
        $gallery = Gallery::with([
            'tags' => function (BelongsToMany $query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);

        $tags = $gallery->tags->pluck('id');
        unset($gallery->tags);
        $gallery->tags = $tags;

        return response()->json(['data' => $gallery]);
    }

    /**
     * @param GalleriesRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(GalleriesRequest $request, int $id): JsonResponse
    {
        return response()->json(
            [
                'status' => GalleryService::manageUpdate($id, $request),
            ]
        );
    }

    /**
     * @param GalleriesRequest $request
     *
     * @return JsonResponse
     */
    public function store(GalleriesRequest $request): JsonResponse
    {
        return response()->json(
            [
                'status' => GalleryService::manageCreate($request),
            ]
        );
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $gallery = Gallery::query()->findOrFail($id);

        return response()->json(['status' => (bool)$gallery->delete()]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $file = FileService::create($request->file()['file']);

        return response()->json(
            [
                'status' => (bool)$file,
                'data' => $file,
            ]
        );
    }
}
