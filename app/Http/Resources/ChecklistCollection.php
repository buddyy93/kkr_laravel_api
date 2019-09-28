<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use function foo\func;

class ChecklistCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($item, $key) {
                return [
                    'type' => strtolower(class_basename($item)),
                    'id'         => $item['id'],
                    'attributes' => $item->makehidden('id')->toArray(),
                    'links'      => [
                        'self' => $item->link()
                    ]
                ];
            })->toArray()
        ];
    }

    public function with($request)
    {
        return [
            'meta' => [
                'count' => $this->collection->count(),
            ],
        ];
    }
}
