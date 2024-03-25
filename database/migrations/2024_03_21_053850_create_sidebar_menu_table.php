<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidebarMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidebar_menu', function (Blueprint $table) {
            $table->id();
            $table->string('label', 255);
            $table->enum('type', ['label', 'link']);
            $table->unsignedInteger('parent_id')->nullable();
            $table->text('url')->nullable();
            $table->enum('url_type', ['default', 'route'])->nullable();
            $table->text('description')->nullable();
            $table->enum('target', ['_blank', '_self'])->nullable();
            $table->unsignedInteger('sequence');
            $table->string('icon', 255)->nullable();
            $table->enum('icon_type', ['class', 'image']);
            $table->boolean('active', 1);
            $table->unsignedInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sidebar_menu');
    }
}
