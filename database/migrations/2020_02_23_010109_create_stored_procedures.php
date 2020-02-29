<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoredProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE PROCEDURE migrate() BEGIN 
         INSERT INTO transfer_group_users 
            (  `id` ,
              `user_id` ,
              `group_id` ,
              `entered_by` ,
              `created_at` ,
              `updated_at` )
         SELECT
            `id` ,
            `member_id` ,
            `group_id` ,
            `entered_by` ,
            `created_at` ,
            `updated_at` 
            FROM member_groups;

        INSERT INTO transfer_groups ( 
            `id`,
            `name`,
            `description`,
            `category`,
            `created_at`,
            `updated_at` )
        SELECT 
            `id`,
            `name`,
            `description`,
            `category`,
            `created_at`,
            `updated_at` 
            FROM groups;

        INSERT INTO transfer_users ( 
            `id`,
            `member_type`,
            `old_username`,
            `password`,
            `old_password`,
            `sponsor_id`,
            `notes`,
            `full_member_date`,
            `aspiration`,
            `meetup_id`,
            `badge_number`,
            `family_primary_member_id`,
            `last_login`,
            `phone`,
            `stripe_subscription_plan`,
            `stripe_id`,
            `card_brand`,
            `card_last_four`,
            `confirmed_at`,
            `confirmation_code`,
            `created_at`,
            `updated_at`,
            `name` ,
            `email`)
        SELECT 
        `id`,
        `member_type`,
        `old_username`,
        `password`,
        `old_password`,
        `sponsor_id`,
        `notes`,
        `full_member_date`,
        `aspiration`,
        `meetup_id`,
        `badge_number`,
        `family_primary_member_id`,
        `last_login`,
        `phone`,
        `stripe_subscription_plan`,
        `stripe_id`,
        `card_brand`,
        `card_last_four`,
        `confirmed_at`,
        `confirmation_code`,
        `created_at`,
        `updated_at`,
        `name`,
        `email`
        FROM members;
         
         END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('BEGIN DROP PROCEDURE IF EXISTS migrate END');
    }
}
