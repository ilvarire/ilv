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
        Schema::create('generals', function (Blueprint $table) {
            $table->id();
            $table->boolean('maintenance')->default(false);
            $table->string('site_description');
            $table->string('site_title');
            $table->string('top_text');
            $table->string('og_image');
            $table->string('favicon');
            $table->string('logo');
            $table->text('policy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generals');
    }
};
