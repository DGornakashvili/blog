<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Services\FileService;
use App\Services\Models\NewsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class NewsController
 *
 * @package App\Http\Controllers
 */
class NewsController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('admin.news.index');
    }

    /**
     * @param int $id
     *
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        return view('admin.news.edit', ['id' => $id]);
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('admin.news.create');
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(['data' => News::query()->findOrFail($id)]);
    }

    /**
     * @param NewsRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(NewsRequest $request, int $id): JsonResponse
    {
        return response()->json(
            [
                'status' => NewsService::manageUpdate($id, $request),
            ]
        );
    }

    /**
     * @param NewsRequest $request
     *
     * @return JsonResponse
     */
    public function store(NewsRequest $request): JsonResponse
    {
        return response()->json(
            [
                'status' => NewsService::manageCreate($request),
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
        $news = News::query()->findOrFail($id);

        return response()->json(['status' => (bool)$news->delete()]);
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
