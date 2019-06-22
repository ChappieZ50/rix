<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRixMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rix_messages', function (Blueprint $table) {
            $table->bigIncrements('message_id');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('subject', 255);
            $table->text('message');
            $table->string('status', 30)->default('unread')->nullable();
            $table->string('readable_date',25);
            $table->string('before_status', 30)->nullable();
            $table->ipAddress('ip')->nullable();
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
        Schema::dropIfExists('rix_messages');
    }
}
