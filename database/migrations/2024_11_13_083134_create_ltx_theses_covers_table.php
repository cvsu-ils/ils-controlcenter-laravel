<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLtxThesesCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ltx_theses_covers', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->unsignedBigInteger('thesis_id');
            $table->integer('updated_by');
            $table->timestamps();

            $table->foreign('thesis_id')->references('id')->on('ltx_theses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ltx_theses_covers');
    }
}
