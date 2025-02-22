<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRixPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rix_posts', function (Blueprint $table) {
            $table->bigIncrements('post_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('summary');
            $table->integer('featured_image');
            $table->string('seo_title');
            $table->text('seo_description');
            $table->text('seo_keywords')->nullable();
            $table->integer('featured')->default(0);
            $table->string('status',10)->default('open');
            $table->string('before_status',10)->nullable();
            $table->integer('slider')->default(0);
            $table->text('url')->nullable();
            $table->foreign('author_id')->references('user_id')->on('rix_users')->onDelete('cascade');
            $table->unsignedBigInteger('author_id');
            $table->string('readable_date',25);
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
        Schema::dropIfExists('rix_posts');
    }
}
