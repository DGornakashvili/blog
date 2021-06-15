<?php

namespace App\Http\Resources;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class GalleriesResource
 *
 * @package App\Http\Resources
 *
 * @property string $uuid
 * @property Collection $tags
 * @property string $img
 * @property string $description
 */
class GalleriesResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'guid' => $this->uuid,
            'tags' => TagsResource::collection($this->tags),
            'img' => $this->img,
            'description' => $this->description,
        ];
    }
}
