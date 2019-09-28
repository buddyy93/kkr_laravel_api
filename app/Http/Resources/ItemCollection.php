<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemCollection extends ResourceCollection
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
                    'item_id'      => $item['id'],
                    'is_completed' => $item['is_completed'],
                    'checklist_id' => $item['checklist_id']
                ];
            })->toArray()
        ];
    }
}
