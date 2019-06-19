<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRixImageRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rix_image_relationships', function (Blueprint $table) {
            $table->bigIncrements('relation_id');
            $table->morphs('meta');
            $table->foreign('image_id')->references('image_id')->on('rix_gallery')->onDelete('cascade');
            $table->unsignedBigInteger('image_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rix_image_relationships');
    }
}
