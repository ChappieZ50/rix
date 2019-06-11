<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRixCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rix_comments', function (Blueprint $table) {
            $table->bigIncrements('comment_id');
            $table->string('name',255);
            $table->string('email',255);
            $table->text('comment');
            $table->ipAddress('ip');
            $table->foreign('post_id')->references('post_id')->on('rix_posts')->onDelete('cascade');
            $table->unsignedBigInteger('post_id');
            $table->string('status',30);
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
        Schema::dropIfExists('rix_comments');
    }
}