<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TemplateCollection extends ResourceCollection
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
                    'name'       => $item['name'],
                    'items'      => $item->items,
                    'checklists' => $item->checklist
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
