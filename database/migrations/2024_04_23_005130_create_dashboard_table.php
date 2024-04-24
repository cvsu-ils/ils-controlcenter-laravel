<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100);
            $table->string('label', 100);
            $table->string('key', 100);
            $table->string('value', 255)->nullable();
            $table->string('class_color', 50)->nullable();
            $table->string('class_icon', 50)->nullable();
            $table->tinyInteger('active');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dashboard');
    }
}
