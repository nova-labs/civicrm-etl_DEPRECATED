<?php

namespace App\Console\Commands;

use App\TransferUser;
use Illuminate\Console\Command;

class TransformMakeUniqueNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:MakeUniqueNames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $transfer_users = TransferUser::orderBy('id', 'desc')->get();

        foreach ($transfer_users as $transfer_user) {

            $same_name_users_count = TransferUser::where('name', '=',$transfer_user->name)->count();

            if($same_name_users_count >1){
                $transfer_user->name = $transfer_user->name . ' ' . $same_name_users_count;
                $transfer_user->save();
            }

        }

    }
}
