<?php

namespace Tests\Feature;

use App\Http\Resources\Template as TemplateResource;
use Tests\TestCase;
use Facades\Tests\Feature\Setup\TemplateFactory;

class ManageTemplateTest extends TestCase
{
    /** @test */
    public function user_can_create_checklist_template()
    {
        $this->authenticate();
        $data = [
            "data" => [
                "attributes" => [
                    "name"      => "foo template",
                    "checklist" => [
                        "description"  => "my checklist",
                        "due_interval" => 3,
                        "due_unit"     => "hour"
                    ],
                    "items"     => [
                        [
                            "description"  => "my foo item",
                            "urgency"      => 2,
                            "due_interval" => 40,
                            "due_unit"     => "minute"
                        ],
                        [
                            "description"  => "my bar item",
                            "urgency"      => 3,
                            "due_interval" => 30,
                            "due_unit"     => "minute"
                        ]
                    ]
                ]
            ]
        ];
        $response = $this->post('/api/checklists/templates', $data);

        $returned_data = $response->decodeResponseJson();
        $data['data']['id'] = 1;
        $data['data']['type'] = 'template';
        $data['data']['links'] = $returned_data['data']['links'];
        $this->assertEquals($data, $returned_data);
    }

    /** @test */
    public function user_can_list_all_checklist_templates()
    {
        $this->authenticate();
        TemplateFactory::withChecklistTemplate()->withItemTemplate()->create();
        TemplateFactory::withChecklistTemplate()->withItemTemplate()->create();

        $response = $this->get('/api/checklists/templates');
        $response->assertJsonCount(2, 'data');
    }

    /** @test */
    public function user_can_view_template_by_given_template_id()
    {
        $this->authenticate();
        $template = TemplateFactory::withChecklistTemplate()->withItemTemplate()->create();

        $response = $this->get('/api/checklists/templates/1');
        $template_resource = new TemplateResource($template);
        $data['data'] = $template_resource->toArray(null);
        $data['data']['attributes']['checklist'] = $data['data']['attributes']['checklist']->toArray();
        $returned_data = $response->decodeResponseJson();

        $this->assertEquals($data, $returned_data);

    }

    /** @test */
    public function user_can_edit_template_by_given_template_id()
    {
        $this->authenticate();
        TemplateFactory::withChecklistTemplate()->withItemTemplate()->create();

        $data = [
            "data" => [
                "name"      => "foo template",
                "checklist" => [
                    "description"  => "my checklist",
                    "due_interval" => 3,
                    "due_unit"     => "hour"
                ],
                "items"     => [
                    [
                        "description"  => "my foo item",
                        "urgency"      => 2,
                        "due_interval" => 40,
                        "due_unit"     => "minute"
                    ],
                    [
                        "description"  => "my bar item",
                        "urgency"      => 3,
                        "due_interval" => 30,
                        "due_unit"     => "minute"
                    ]
                ]
            ]
        ];

        $response = $this->patch('/api/checklists/templates/1', $data);

        $returned_data = $response->decodeResponseJson()['data'];

        $this->assertEquals($data['data']['name'], $returned_data['attributes']['name']);
        $this->assertEquals($data['data']['checklist'], $returned_data['attributes']['checklist']);
        $this->assertEquals($data['data']['items'], $returned_data['attributes']['items']);
    }

    /** @test */
    public function user_can_delete_template_by_given_template_id()
    {
        $this->authenticate();
        TemplateFactory::withChecklistTemplate()->withItemTemplate()->create();

        $this->delete('/api/checklists/templates/1')->assertStatus(200);
    }
}
