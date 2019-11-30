<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('member_type')->default('Guest');
            $table->string('old_username')->nullable();
            $table->string('old_password')->nullable();
            $table->integer('sponsor_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->date('full_member_date')->nullable();
            $table->string('aspiration')->nullable();
            $table->string('meetup_id')->nullable();
            $table->string('badge_number')->nullable();
            $table->integer('family_primary_member_id')->unsigned()->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('phone', 15)->nullable();

            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();

            $table->dateTime('confirmed_at')->nullable();
            $table->string('confirmation_code')->nullable();

            $table->boolean('not_migrated')->default(true);
            $table->boolean('transfer')->default(true);

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
        Schema::dropIfExists('transfer_users');
    }
}
