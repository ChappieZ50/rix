<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRixGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rix_gallery', function (Blueprint $table) {
            $table->bigIncrements('image_id');
            $table->text('image_name'); // Image Random Name
            $table->text('image_data'); // Image Data (Width,Height,Extension,Size,MimeType)
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
        Schema::dropIfExists('rix_gallery');
    }
}
