<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferStripeSubscriptionsRaw extends Model
{
    protected $table = 'stripe_subscriptions_raw';

    protected $fillable = ['subscription_id','raw_json'];
}
