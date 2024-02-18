<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('knowledge_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('id')->on('knowledge_topics');
            $table->string('title');
            $table->text('description');
            $table->string('author');
            $table->string('title_img')->nullable();
            $table->integer('length');
            $table->longText('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('knowledge_articles');
    }
}
