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
        Schema::create('contestants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('advocacy'); 
            $table->string('photo')->nullable();
            $table->string('address');
            $table->unsignedInteger('age');
            $table->string('chest');
            $table->string('waist');
            $table->string('hips');
            $table->string('height');
            $table->string('weight');
            $table->unsignedInteger('contestantNum');
            $table->unsignedInteger('eventID');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contestants');
    }
};
