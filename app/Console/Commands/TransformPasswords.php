<?php

namespace App\Console\Commands;

use App\TransferUser;
use Illuminate\Console\Command;

class TransformPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:SetPassword';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set password to only SSHA and correct delimiter';

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
            $password_array = explode(' ', $transfer_user->old_password);
            foreach ($password_array as $entry){
                if (substr($entry, 0, 6) == '{SSHA}')
                {
                    $salted_sha = substr($entry, 6);
                }
            }
            if($salted_sha)
            {
                $password = '$SSHA$' . $salted_sha;
                $transfer_user->password = $password;
            }
            else
            {
                $transfer_user->password = '';
            }
            $transfer_user->save();
        }

    }
}
