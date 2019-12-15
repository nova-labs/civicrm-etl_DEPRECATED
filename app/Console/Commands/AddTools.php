<?php

namespace App\Console\Commands;

use App\TransferGroup;
use Illuminate\Console\Command;
use Leanwebstart\CiviApi3\CiviApi;

class AddTools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:AddTools';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add tools civicrm';

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
        $tools = TransferGroup::where('transfer', 1)->where('not_migrated',1)->get();

        //dd($tools);

        foreach($tools as $tool){

            $tool_values = [
                'contact_type' => "Individual",
                "contact_sub_type" =>  "Tool",
                'first_name' => $tool->tool_type,
                'last_name' => $tool->tool_name,

                ];

            $api = new CiviApi();

            $result = $api->Contact->Create($tool_values);

            $tool->not_migrated = false;
            $tool->civicrm_id = $result->id;
            $tool->update();
        }


    }
}
