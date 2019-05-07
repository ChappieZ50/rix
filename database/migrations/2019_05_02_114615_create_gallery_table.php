<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('image_name'); // Image Random Name
            $table->text('image_data'); // Image Data (Width,Height,Extension,Size,MimeType)
            
/*            $table->string('meta_table',255)->nullable(); // Table to attach
            $table->string('meta_key',255)->nullable(); // Key for image type (banner,background etc.)
            $table->integer('meta_id')->nullable(); // Table column id*/
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
        Schema::dropIfExists('gallery');
    }
}
