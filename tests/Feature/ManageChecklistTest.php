<?php

namespace Tests\Feature;

use App\Checklist;
use Tests\TestCase;
use Facades\Tests\Feature\Setup\ChecklistFactory;

class ManageChecklistTest extends TestCase
{
    /** @test */
    public function user_can_view_a_checklist()
    {
        $this->authenticate();
        $checklists = ChecklistFactory::createMany(1);
        $this->get('/api/checklists/1')
            ->assertSee($checklists[0]->description)
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_view_a_checklist_With_item_included()
    {
        $this->authenticate();
        $checklist = ChecklistFactory::withItems(2)->create();
        $response = $this->get('/api/checklists/1?include=all');
        $returned_data = $response->decodeResponseJson();
        $this->assertEquals($checklist->items->toArray(), $returned_data['data']['items']);
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_all_checklist()
    {
        $this->authenticate();
        $checklists = ChecklistFactory::createMany(2);
        $response = $this->get('/api/checklists/');
        $response->assertJsonCount($checklists->count(), 'data');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_delete_a_checklist()
    {
        $this->authenticate();
        ChecklistFactory::createMany(2);
        $this->delete('/api/checklists/1')
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_create_a_checklist()
    {
        $this->authenticate();
        $this->post('/api/checklists', ['description' => 'this is the text']);
        $this->get('/api/checklists/1')
            ->assertSee('this is the text')
            ->assertStatus(200);

    }

    /** @test */
    public function user_can_update_a_checklist()
    {
        $this->authenticate();
        ChecklistFactory::createMany(1);
        $this->patch('/api/checklists/1', ['description' => 'updated text']);
        $this->get('/api/checklists/1')
            ->assertSee('updated text')
            ->assertStatus(200);
    }
}
