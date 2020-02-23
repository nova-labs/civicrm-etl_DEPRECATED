<?php

namespace App\Console\Commands;

use App\TransferStripeSubscriptionsRaw;
use Illuminate\Console\Command;
use Stripe\Stripe;
use Stripe\Subscription;

class GetStripeSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:GetStripeSubscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download Stripe Subscriptions and put into table for processing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $subscriptions = Subscription::all(
            //['limit' => 2]
        );

        foreach($subscriptions as $subscription){

            echo 'id: ' . $subscription->id . ' /n';

            $existing_raw = TransferStripeSubscriptionsRaw::where('subscription_id', $subscription->id)->first();

            if (!$existing_raw){
                $raw_entry = new TransferStripeSubscriptionsRaw([
                    'subscription_id' => $subscription->id,
                    'raw_json' => $subscription,
                ]);
                $raw_entry->save();
            }
        }


        //dd($subscriptions->data);

        return(1);
    }
}
