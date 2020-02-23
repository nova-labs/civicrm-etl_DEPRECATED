<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferStripeSubscriptions extends Model
{
    protected $table = 'stripe_subscriptions';

    protected $fillable = ['stripe_subscription_id','stripe_customer_id','stripe_plan_id','stripe_plan_product','stripe_status','stripe_plan_amount'];
}
