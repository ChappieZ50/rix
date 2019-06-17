<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRixSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rix_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('subscription_id');
            $table->string('email',255)->unique();
            $table->ipAddress('ip')->nullable();
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
        Schema::dropIfExists('rix_subscriptions');
    }
}
