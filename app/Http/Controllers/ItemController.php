<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemSummary;
use App\Item;
use App\Http\Resources\Item as ItemResource;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        $items = Item::all();
        $filters = $request->query('filter');
        if (isset($filters)) {
            foreach ($filters as $filter => $value) {
                $items = $items->where($filter, $value['is']);
            }
        }
        $orders = $request->query('sort');
        if (isset($orders)) {
            if (substr($orders, 0, 1) === "-")
                $items = $items->sortByDesc(str_replace('-', '', $orders));
            else
                $items = $items->sortBy($orders);
        }

        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Checklist $checklist)
    {
        return $checklist->items()->create($request['data']['attribute']);
    }

    public function store_bulk(Request $request, Checklist $checklist)
    {
        return $checklist->items()->create($request['data']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checklist $checklist, Item $item)
    {
        $item->update($request['data']['attribute']);

        return (new ItemResource($checklist, $item->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklist, Item $item)
    {
        $item->delete();
    }

    public function complete(Request $request)
    {
        $items = Item::whereIn('id', array_column($request->data, 'item_id'));
        $items->update(['is_completed' => 1]);

        return new ItemCollection($items->get());
    }

    public function incomplete(Request $request)
    {
        $items = Item::whereIn('id', array_column($request->data, 'item_id'));
        $items->update(['is_completed' => 0]);

        return new ItemCollection($items->get());
    }

    public function summaries()
    {
        return new ItemSummary(Item::all());
    }
}
