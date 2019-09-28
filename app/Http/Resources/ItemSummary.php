<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ItemSummary extends JsonResource
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
            'data' => [
                "today"      => $this->where('created_at', '>', Carbon::now())->count(),
                "past_due"   => $this->where('created_at', '>', Carbon::yesterday())->count(),
                "this_week"  => $this->whereBetween('created_at', [(new Carbon('now'))->startOfWeek(),
                                                                   (new Carbon('now'))->endOfWeek()])->count(),
                "past_week"  => $this->whereBetween('created_at', [new Carbon('last week'),
                                                                   new Carbon('now')])->count(),
                "this_month" => $this->whereBetween('created_at', [(new Carbon('now'))->startOfMonth(),
                                                                   (new Carbon('now'))->endOfMonth()])->count(),
                "past_month" => $this->whereBetween('created_at', [new Carbon('last month'),
                                                                   new Carbon('now')])->count(),
                "total"      => $this->count()
            ]
        ];
    }
}
