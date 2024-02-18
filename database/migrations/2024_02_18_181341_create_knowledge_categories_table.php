<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('knowledge_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nav_item');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('knowledge_categories');
    }
}
