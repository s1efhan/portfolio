<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToKnowledgeArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('knowledge_articles', function (Blueprint $table) {
            $table->enum('status', ['public', 'private'])->default('private')->after('title_img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('knowledge_articles', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
