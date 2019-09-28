<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Template extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'       => strtolower(class_basename($this)),
            'id'         => $this->id,
            'attributes' => [
                'name'      => $this->name,
                'items'     => $this->items()->get(['description', 'due_interval', 'due_unit', 'urgency'])->toArray(),
                'checklist' => $this->checklist->get(['description', 'due_interval', 'due_unit'])->first()
            ],
            'links'      => [
                'self' => $this->link()
            ]
        ];
    }
}
