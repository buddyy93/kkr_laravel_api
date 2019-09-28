<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Facades\Tests\Feature\Setup\ChecklistFactory;
use Tests\TestCase;

class ManageItemTest extends TestCase
{
    /** @test */
    public function user_can_create_item_by_given_checklist_id()
    {
        $this->authenticate();
        ChecklistFactory::create();
        $this->post('/api/checklists/1/items', [
            'data' => [
                'attribute' => [
                    'description' => 'this is item'
                ]
            ]
        ]);

        $this->get('/api/checklists/1/items')
            ->assertSee('this is item')
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_complete_items()
    {
        $this->authenticate();
        ChecklistFactory::withItems(2)->create();
        $this->post('/api/checklists/complete', [
            'data' => [
                ['item_id' => 1],
                ['item_id' => 2]
            ]
        ])
            ->assertJsonStructure([
                'data' => [
                    [
                        "item_id",
                        "is_completed",
                        "checklist_id"
                    ]
                ],
            ])
            ->assertSee('is_completed":true')
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_incomplete_items()
    {
        $this->authenticate();
        ChecklistFactory::withItems(2)->create();
        $this->post('/api/checklists/incomplete', [
            'data' => [
                ['item_id' => 1],
                ['item_id' => 2]
            ]
        ])
            ->assertJsonStructure([
                'data' => [
                    [
                        "item_id",
                        "is_completed",
                        "checklist_id"
                    ]
                ],
            ])
            ->assertSee('is_completed":false')
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_get_all_items_by_given_checklist_id()
    {
        $this->authenticate();
        $checklist = ChecklistFactory::withItems(2)->create();
        $response = $this->get('/api/checklists/1/items');
        $data = $response->decodeResponseJson()['data']['items'];

        $this->assertEquals($data, $checklist->items->toArray());
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_get_checklist_item_by_given_checklist_id_and_item_id()
    {
        $this->authenticate();
        $checklist = ChecklistFactory::withItems(2)->create();
        $response = $this->get('/api/checklists/1/items/2');
        $data = $response->decodeResponseJson()['data']['attributes'];

        $this->assertEquals($data, $checklist->items->find(2)->makehidden('id')->toArray());
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_edit_checklist_item_by_given_checklist_id_and_item_id()
    {
        $this->authenticate();
        $checklist = ChecklistFactory::withItems(2)->create();
        $response = $this->patch('/api/checklists/1/items/2', [
            "data" => [
                "attribute" => [
                    "description" => "Need to verify this guy house.",
                    "due"         => "2019-01-19 18:34:51",
                    "urgency"     => "2",
                    "assigned_id" => 123
                ]
            ]
        ]);
        $data = $response->decodeResponseJson()['data']['attributes'];

        $this->assertEquals($data, $checklist->items->find(2)->makehidden('id')->toArray());
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_delete_checklist_item_by_given_checklist_id_and_item_id()
    {
        $this->authenticate();
        ChecklistFactory::withItems(2)->create();
        $this->delete('/api/checklists/1/items/2')->assertStatus(200);
    }

    /** @test */
    public function user_can_view_summary_of_checklists_items()
    {
        $this->authenticate();
        $this->get('/api/checklists/items/summaries')->assertJsonStructure([
            'data' => [
                "today",
                "past_due",
                "this_week",
                "past_week",
                "this_month",
                "past_month",
                "total"
            ]
        ])->assertStatus(200);

    }

    /** @test */
    public function user_can_view_all_checklists_items()
    {
        $this->authenticate();
        ChecklistFactory::withItems(5)->create();
        $this->get('/api/checklists/items')->assertStatus(200);
    }
}
