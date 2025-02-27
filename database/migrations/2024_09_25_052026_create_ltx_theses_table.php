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
            $table->string('title');
            $table->integer('year');          
            $table->string('publisher');
            $table->string('publication_place');          
            $table->string('item_type_id');
            $table->string('language');
            $table->string('subject_code_id');
            $table->string('program_id');
            $table->string('range');
            $table->string('cutter_ending');
            $table->integer('pages');
            $table->string('physical_description')->nullable();
            $table->string('general_notes')->nullable();
            $table->string('bibliography')->nullable();
            $table->string('summary')->nullable();
            $table->string('table_of_contents')->nullable();          
            $table->integer('submitted_id')->nullable();
            $table->integer('full_text_id')->nullable();
            $table->integer('cover_id')->nullable();
            $table->string('cover_filename')->nullable();     
            $table->string('created_by');
            $table->boolean('is_published')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->boolean('active')->default(1);
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
