<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeSubscriptionsRaw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_subscriptions_raw', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('processed')->default(false);
            $table->string('subscription_id');
            $table->text('raw_json');
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
        Schema::dropIfExists('stripe_raw');
    }
}
