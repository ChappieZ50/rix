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
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->text('comment');
            $table->ipAddress('ip')->nullable();
            $table->foreign('parent_comment')->references('comment_id')->on('rix_comments')->onDelete('cascade');
            $table->unsignedBigInteger('parent_comment')->nullable();
            $table->foreign('post_id')->references('post_id')->on('rix_posts')->onDelete('cascade');
            $table->unsignedBigInteger('post_id');
            $table->foreign('user_id')->references('user_id')->on('rix_users')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status', 30)->default('pending');
            $table->string('before_status', 30)->nullable();
            $table->string('readable_date', 30);
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
