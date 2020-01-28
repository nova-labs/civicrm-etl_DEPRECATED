<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stripe_subscription_id');
            $table->string('stripe_customer_id');
            $table->string('stripe_plan_id');
            $table->string('stripe_plan_product');
            $table->string('stripe_status');
            $table->integer('stripe_plan_amount');
            $table->boolean('migrate')->default(true);
            $table->boolean('processed')->default(false);
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
        Schema::dropIfExists('stripe_subscriptions');
    }
}
