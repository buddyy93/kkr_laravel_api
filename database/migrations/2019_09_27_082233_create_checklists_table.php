<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('object_domain')->nullable();
            $table->string('object_id')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('due')->default(null)->nullable();
            $table->integer('urgency')->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklists');
    }
}
