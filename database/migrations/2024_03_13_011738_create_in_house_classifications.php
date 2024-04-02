<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInHouseClassifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_house_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->string('alphabetic_range');
            $table->string('numeric_range');
            $table->integer('updated_by');
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
        Schema::dropIfExists('in_house_classifications');
       
    }
}
