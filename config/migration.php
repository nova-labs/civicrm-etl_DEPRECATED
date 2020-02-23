<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Users per Migration
    |--------------------------------------------------------------------------
    |
    | This option is designed to allow default testing
    |
    |
    */

    'users_per_round' => 250,

    /*
    |--------------------------------------------------------------------------
    | Membership Type Handling
    |--------------------------------------------------------------------------
    |
    | List membership types to migrate. And how to migrate them.
    |
    */

    'membership_types' => [
        'Member' => 'subscription',
        'Associate' => 'subscription',
        'Attendee' => 'id_only'
    ],

    /*
    |--------------------------------------------------------------------------
    |  Plan to membership
    |--------------------------------------------------------------------------
    |
    | Map plans to membership type
    |
    */

    'plan_to_membership' => [
        'dues.member' => 'Member',
        'dues.associate' => 'Associate',
        'dues-associate' => 'Associate'
    ],


];
