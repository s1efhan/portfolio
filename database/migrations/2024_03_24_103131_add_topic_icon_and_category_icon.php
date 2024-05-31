<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('knowledge_topics', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('status'); // 'icon' als nullable string hinzufügen
        });

        // Überprüfen, ob die Spalte "icon" bereits vorhanden ist, bevor sie umbenannt wird
        if (!Schema::hasColumn('knowledge_categories', 'icon')) {
            Schema::table('knowledge_categories', function (Blueprint $table) {
                $table->string('icon')->nullable()->after('status'); // 'icon' als nullable string hinzufügen
                $table->dropColumn('nav_item');
            });
        } else {
            Schema::table('knowledge_categories', function (Blueprint $table) {
                $table->renameColumn('nav_item', 'icon');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knowledge_topics', function (Blueprint $table) {
            $table->dropColumn('icon'); // 'icon'-Spalte entfernen, falls Migration zurückgerollt wird
        });

        Schema::table('knowledge_categories', function (Blueprint $table) {
            $table->renameColumn('icon', 'nav_item');
        });
    }
};
