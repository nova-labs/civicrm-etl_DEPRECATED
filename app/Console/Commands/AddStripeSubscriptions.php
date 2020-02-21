<?php

namespace App\Console\Commands;

use App\StripeSubscriptions;
use App\TransferUser;
use Illuminate\Console\Command;
use Leanwebstart\CiviApi3\CiviApi;

class AddStripeSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:AddStripeSubscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Stripe subscriptions ';

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
        $subscriptions = StripeSubscriptions::get();

        foreach($subscriptions as $subscription){
            if ($subscription->migrate && !$subscription->processed) {
                //dd($subscription);

                $user = TransferUser::where('email','=',$subscription->stripe_customer_email)->first();
                // data import was different between user and subscriptions - missing user records cause errors

                if ($user){
                    $subscription_values = [
                        'subscription_id' => $subscription->stripe_subscription_id,
                        'contact_id' => $user->civicrm_id,
                        'payment_processor_id' => "1",
                        'membership_id' => $user->civicrm_member_id,
                    ];

                    $api = new CiviApi();

                    $result = $api->StripeSubscription->Import($subscription_values);

                    $subscription->processed = true;
                    $subscription->update();
                    echo ".";
                }
                else{
                    $subscription->migrate = false;
                    $subscription->update();
                    echo 's';
                }
            }
        }
    }
}
