<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLtxThesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ltx_theses', function (Blueprint $table) {
            $table->id();
            $table->string('accession_number')->nullable();
            $table->string('item_type_id');
            $table->string('language');
            $table->string('subject_code_id');
            $table->string('program_id');
            $table->string('title');
            $table->integer('year');
            $table->integer('pages');
            $table->string('publication_place');
            $table->string('publisher');
            $table->string('physical_description')->nullable();
            $table->string('general_notes')->nullable();
            $table->string('bibliography')->nullable();
            $table->string('summary');
            $table->string('table_of_contents')->nullable();
            $table->string('range');
            $table->string('cutter_ending');
            $table->string('opac_link');
            $table->string('cover');
            $table->string('created_by');
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
        Schema::dropIfExists('ltx_theses');
    }
}
