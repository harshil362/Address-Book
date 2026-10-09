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
        if (!Schema::hasTable('mastermodels')) {
            Schema::create('mastermodels', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('permissions') && !Schema::hasColumn('permissions', 'model_id')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->unsignedBigInteger('model_id')->nullable()->after('name');
                $table->foreign('model_id')->references('id')->on('mastermodels')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('permissions') && Schema::hasColumn('permissions', 'model_id')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->dropForeign(['model_id']);
                $table->dropColumn('model_id');
            });
        }

        Schema::dropIfExists('mastermodels');
    }
};
