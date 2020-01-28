<?php

namespace App\Console\Commands;

use App\TransferUser;
use Illuminate\Console\Command;

class TransformFlagBadUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:FlagBadUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sets transfer flag to 0 for users we are not going to pull over';

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
        $max_dots_in_email = 4;

        $transfer_users = TransferUser::get();

        foreach ($transfer_users as $transfer_user) {

            $act_on_record = 0;

            $email = explode('.', $transfer_user->email);

            $tl_domain = $email[count($email)-1];


            if (count($email) < 2){
                $act_on_record = 1;
                $domain = '';
                echo 'b';
            }
            else
            {
                $domain_parts = explode( '@', $email[count($email)-2]);
                $domain = $domain_parts[count($domain_parts)-1];
            }

            // don't transfer any russian emails - dead and intended for spam
            if ($tl_domain == 'ru' or $tl_domain == 'xyz'){
                $act_on_record = 1;
                echo 'r';
            }

            // don't transfer any cherrycreekschools.org, etc. emails - never used
            if ($domain == 'cherrycreekschools'){
                $act_on_record = 1;
                echo 'c';
            }

            if ($domain == 'hayastana'){
                $act_on_record = 1;
                echo 'h';
            }

            if ($domain == 'yandex'){
                $act_on_record = 1;
                echo 'y';
            }

            if ($domain == 'opbeingop'){
                $act_on_record = 1;
                echo 'o';
            }

            // don't transfer accounts with multiple periods - intended for spam
            if (substr_count($transfer_user->email, '.') >$max_dots_in_email){
                $act_on_record = 1;
                echo '#';
            }

            if ($act_on_record){
                $transfer_user->transfer = false;
                $transfer_user->update();
            }

        }


    }
}
