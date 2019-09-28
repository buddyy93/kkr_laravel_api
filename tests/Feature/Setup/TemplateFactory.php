<?php
declare(strict_types=1);


namespace Tests\Feature\Setup;

use App\ChecklistTemplate;
use App\Template;
use App\ItemTemplate;

class TemplateFactory
{
    private $checklist_template_count = 0;
    private $item_template_count = 0;

    public function withChecklistTemplate($count = 1)
    {
        $this->checklist_template_count = $count;

        return $this;
    }

    public function withItemTemplate($count = 1)
    {
        $this->item_template_count = $count;

        return $this;
    }

    public function create()
    {
        $template = factory(Template::class)->create();;

        factory(ChecklistTemplate::class, $this->checklist_template_count)->create([
            'template_id' => $template->id
        ]);

        factory(ItemTemplate::class, $this->item_template_count)->create([
            'template_id' => $template->id
        ]);

        return $template;
    }

    public function createMany($count)
    {
        return factory(Template::class, $count)->create();
    }
}
