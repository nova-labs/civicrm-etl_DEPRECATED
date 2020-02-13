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

        $bar = $this->output->createProgressBar(count($transfer_users));
        $bar->start();

        foreach ($transfer_users as $transfer_user) {
            if ($transfer_user->transfer && $transfer_user->not_migrated){

                $name = explode(' ', $transfer_user->name);

                $first_name = $last_name = $middle_name ='';

                $fix_name = 0;

                switch (count($name)) {
                    case 0:
                        $fix_name = 1;
                        break;
                    case 1:
                        $last_name = $name[0];
                        break;
                    case 2:
                        $first_name = $name[0];
                        $last_name = $name[1];
                        break;
                    case 3:
                        $first_name = $name[0];
                        $middle_name = $name[1];
                        $last_name = $name[2];
                        break;
                    case 4:
                        $first_name = $name[0];
                        $middle_name = $name[1];
                        $last_name = $name[2] . ' ' . $name[3];
                        $fix_name = 1;
                    case 5:
                        break;
                    default:
                        $fix_name = 1;
                        break;
                }


                $user_values = [
                    'contact_type' => "Individual",
                    'first_name' => $first_name,
                    'middle_name' => $middle_name,
                    'last_name' => $last_name,
                    'email' => $transfer_user->email,
                    'do_not_trade' => $fix_name,

                ];

                $api = new CiviApi();

                $result = $api->Contact->Create($user_values);

                $transfer_user->not_migrated = false;
                $transfer_user->civicrm_id = $result->id;
                $transfer_user->update();

                $bar->advance();
            }
        }
        $bar->finish();
    }
}
