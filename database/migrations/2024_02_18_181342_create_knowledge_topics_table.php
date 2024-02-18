<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeTopicsTable extends Migration
{
    public function up()
    {
        Schema::create('knowledge_topics', function (Blueprint $table) {
            $table->id();
            $table->string('topic_name');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('knowledge_categories');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('knowledge_topics');
    }
}
