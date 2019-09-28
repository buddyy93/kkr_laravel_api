<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\Http\Resources\ChecklistCollection;
use App\Http\Resources\Checklist as ChecklistResource;
use App\Http\Resources\Item as ItemResource;
use App\Item;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{

    public function index()
    {
        return new ChecklistCollection(Checklist::paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Checklist::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Checklist $checklist
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Checklist $checklist)
    {
        if ($request->query->get('include') === 'all')
            return (new ChecklistResource($checklist, 1));
        else
            return (new ChecklistResource($checklist));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Checklist $checklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checklist $checklist)
    {
        $checklist->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Checklist $checklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklist)
    {
        $checklist->delete();
    }

    public function items(Checklist $checklist)
    {
        return (new ChecklistResource($checklist, 1));
    }

    public function item(Checklist $checklist, Item $item)
    {
        return (new ItemResource($checklist, $item->id));
    }
}
