<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferGroupUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_group_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id',false, true);
            $table->integer('group_id',false, true);
            $table->integer('entered_by',false, true)->nullable();

            $table->boolean('not_migrated')->default(true);
            $table->boolean('transfer')->default(true);

            $table->integer('civicrm_id')->unsigned()->nullable();

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
        Schema::dropIfExists('transfer_group_users');
    }
}
