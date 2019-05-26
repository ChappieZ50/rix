<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRixTermRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rix_term_relationships', function (Blueprint $table) {
            $table->bigIncrements('term_relationships_id');
            $table->foreign('post_id')->references('post_id')->on('rix_posts')->onDelete('cascade');
            $table->unsignedBigInteger('post_id');
            $table->foreign('term_taxonomy_id')->references('term_taxonomy_id')->on('rix_term_taxonomy')->onDelete('cascade');
            $table->unsignedBigInteger('term_taxonomy_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rix_term_relationships');
    }
}
