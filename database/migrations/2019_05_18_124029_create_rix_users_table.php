<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRixUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rix_users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('name');
            $table->string('slug');
            $table->string('username')->unique();
            $table->string('avatar')->nullable();
            $table->text('avatar_data')->nullable();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('role', 10)->default('user');
            $table->string('readable_date', 25);
            $table->string('status')->default('ok')->nullable();
            $table->text('status_data')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('rix_users');
    }
}
