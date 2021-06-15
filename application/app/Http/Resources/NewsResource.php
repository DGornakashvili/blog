<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

/**
 * Class NewsResource
 * @package App\Http\Resources
 *
 * @property int $id
 * @property string $slug
 * @property string $preview
 * @property string $main_image
 * @property string $created_at
 * @property string $header
 * @property string $content
 */
class NewsResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'preview' => $this->preview,
            'main_image' => Storage::url($this->main_image),
            'created_at' => $this->created_at,
            'header' => $this->header,
            'content' => $this->content,
        ];
    }
}
