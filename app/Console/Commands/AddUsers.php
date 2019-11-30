<?php

namespace App\Console\Commands;

use App\TransferUser;
use Illuminate\Console\Command;
use Leanwebstart\CiviApi3\CiviApi;

class AddUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:AddUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add all all the transfer users';

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
        $transfer_users = TransferUser::get();

        foreach ($transfer_users as $transfer_user) {
            if ($transfer_user->transfer && $transfer_user->not_migrated){

                $name = explode(' ', $transfer_user->name);
                $first_name = $name[0];

                if (count($name) > 1)
                {
                    $last_name = $name[1];
                    // todo: fix for
                }
                else
                    $last_name = '';

                $user_values = [
                    'contact_type' => "Individual",
                    'display_name' => $transfer_user->name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $transfer_user->email,
                ];

                $api = new CiviApi();

                $result = $api->Contact->Create($user_input);

                $transfer_user->not_migrated = false;
                $transfer_user->update();

            }
        }
    }
}
