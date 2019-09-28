<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('checklist_id');
            $table->string('description')->nullable();
            $table->boolean('is_completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->string('due')->default(null)->nullable();
            $table->integer('urgency')->default(null)->nullable();
            $table->string('updated_by')->nullable();
            $table->string('assigned_id')->default(null)->nullable();
            $table->integer('task_id')->default(null)->nullable();
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
        Schema::dropIfExists('items');
    }
}
