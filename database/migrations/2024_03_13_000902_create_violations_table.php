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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            // $table->integer('user_id');
            $table->integer('card_number')->unique();
            $table->string('violation_desc');
            $table->string('violation_type');
            $table->string('dateEnded')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();

        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
