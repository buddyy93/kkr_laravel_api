<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Checklist extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private $getItem = 0;

    private $item = null;

    public function __construct($resource, $getItem = 0, $item = null)
    {
        parent::__construct($resource);

        $this->getItem = $getItem;

        $this->item = $item;
    }

    public function toArray($request)
    {
        $checklist = [
            'type'       => strtolower(class_basename($this)),
            'id'         => $this->id,
            'attributes' => $this->makehidden('id')->toArray(),
            'links'      => [
                'self' => $this->link()
            ]
        ];

        if ($this->getItem) {
            $checklist['items'] = $this->items;
        } else if (isset($this->item)) {
            $checklist['item'] = $this->item;
        }

        return $checklist;
    }
}
