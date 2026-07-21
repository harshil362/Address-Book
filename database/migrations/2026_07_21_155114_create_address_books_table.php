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
        Schema::create('address_books', function (Blueprint $table) {
            $table->id();

            $table->string('contact_type');

            $table->string('name');

            $table->string('mobile');

            $table->string('alternate_mobile')->nullable();

            $table->string('email')->nullable();

            $table->foreignId('country_id')->constrained()->onDelete('cascade');

            $table->foreignId('state_id')->constrained()->onDelete('cascade');

            $table->foreignId('city_id')->constrained()->onDelete('cascade');

            $table->foreignId('area_id')->constrained()->onDelete('cascade');

            $table->text('address1');

            $table->text('address2')->nullable();

            $table->string('landmark')->nullable();

            $table->string('pincode');

            $table->boolean('is_default')->default(false);

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_books');
    }
};
