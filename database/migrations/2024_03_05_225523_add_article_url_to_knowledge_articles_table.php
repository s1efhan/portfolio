<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArticleUrlToKnowledgeArticlesTable extends Migration
{
    /**
     * Führt die Migration durch.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('knowledge_articles', function (Blueprint $table) {
            // Überprüfen, ob die Spalte bereits vorhanden ist
            if (!Schema::hasColumn('knowledge_articles', 'article_url')) {
                $table->string('article_url', 100)->unique()->nullable(false)->after('id');
            }
        });
    }

    /**
     * Rollt die Migration zurück.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('knowledge_articles', function (Blueprint $table) {
            $table->dropColumn('article_url');
        });
    }
}
