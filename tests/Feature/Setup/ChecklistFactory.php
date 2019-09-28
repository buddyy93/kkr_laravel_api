<?php
declare(strict_types=1);


namespace Tests\Feature\Setup;

use App\Checklist;
use App\Item;

class ChecklistFactory
{
    private $item_count = 0;

    public function withItems($count = 1)
    {
        $this->item_count = $count;

        return $this;
    }

    public function create()
    {
        $checklist = factory(Checklist::class)->create();;

        factory(Item::class, $this->item_count)->create([
            'checklist_id' => $checklist->id
        ]);

        return $checklist;
    }

    public function createMany($count)
    {
        return factory(Checklist::class, $count)->create();
    }
}
