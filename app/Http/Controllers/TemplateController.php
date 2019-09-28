<?php

namespace App\Http\Controllers;

use App\ChecklistTemplate;
use App\Http\Resources\TemplateCollection;
use App\Template;
use App\Http\Resources\Template as TemplateResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new TemplateCollection(Template::paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $template = Template::create(['name' => $request['data']['attributes']['name']]);
        if (isset($request['data']['attributes']['checklist'])) {
            $template->checklist()->create($request['data']['attributes']['checklist']);

            if ($request['data']['attributes']['items']) {
                foreach ($request['data']['attributes']['items'] as $item) {
                    $template->items()->create($item);
                }
            }
        }

        return new TemplateResource($template);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Template $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        return new TemplateResource($template);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Template $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        DB::table('checklist_templates')->where('template_id', $template->id)->delete();
        DB::table('item_templates')->where('template_id', $template->id)->delete();

        $template->name = $request['data']['name'];
        $template->save();
        if (isset($request['data']['checklist'])) {
            $template->checklist()->create($request['data']['checklist']);

            if ($request['data']['items']) {
                foreach ($request['data']['items'] as $item) {
                    $template->items()->create($item);
                }
            }
        }

        return new TemplateResource($template);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Template $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        $template->delete();
    }
}
