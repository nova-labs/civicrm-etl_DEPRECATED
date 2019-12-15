<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64);
            $table->string('description')->nullable();
            $table->integer('category')->unsigned()->nullable();

            $table->boolean('not_migrated')->default(true);
            $table->boolean('transfer')->default(false);

            $table->integer('civicrm_id')->unsigned()->nullable();

            $table->string('tool_name', 64)->nullable();
            $table->string('tool_type', 64)->nullable();

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
        Schema::dropIfExists('transfer_groups');
    }
}
