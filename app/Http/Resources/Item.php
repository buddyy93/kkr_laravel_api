<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    private $item_id;

    public function __construct($resource, $item_id)
    {
        parent::__construct($resource);

        $this->item_id = $item_id;
    }

    public function toArray($request)
    {
        $item = [
            'type'       => strtolower(class_basename($this)),
            'id'         => $this->id,
            'attributes' => $this->items->find($this->item_id)->makehidden('id')->toArray(),
            'links'      => [
                'self' => $this->link()
            ]
        ];

        return $item;
    }
}
