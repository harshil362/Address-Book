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

            $table->string('mobile_no', 10);

            $table->string('alternate_mobile', 10)->nullable();

            $table->string('email')->nullable();

            $table->foreignId('country_id')->constrained()->cascadeOnDelete();

            $table->foreignId('state_id')->constrained()->cascadeOnDelete();

            $table->foreignId('city_id')->constrained()->cascadeOnDelete();

            $table->foreignId('area_id')->constrained()->cascadeOnDelete();

            $table->string('address_line_1');

            $table->string('address_line_2')->nullable();

            $table->string('landmark')->nullable();

            $table->string('pincode');

            $table->boolean('is_default_address')->default(0);

            $table->boolean('status')->default(1);

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
