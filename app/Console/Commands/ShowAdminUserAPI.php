<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Leanwebstart\CiviApi3\CiviApi;

class ShowAdminUserAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ShowAdminUserAPI';

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
        $api = new CiviApi();

       //dd(config('civi-api3.civi_host'));

        $result = $api->Contact->Get(2);


        dd ($result);
    }
}
