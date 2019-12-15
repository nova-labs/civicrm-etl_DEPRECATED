<?php

namespace App\Console\Commands;

use App\TransferGroup;
use App\TransferGroupUser;
use App\TransferUser;
use Illuminate\Console\Command;
use Leanwebstart\CiviApi3\CiviApi;

class AddSignOffs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:AddSignOffs';

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
        $signoffs = TransferGroupUser::where('transfer', 1)->where('not_migrated',1)->get();

        foreach($signoffs as $signoff){

            $user = TransferUser::where('id', $signoff->user_id )->first();
            $user_active = ($user and $user->civicrm_id);

            $tool = TransferGroup::where('id', $signoff->group_id )->first();
            $tool_active = ($tool and $tool->civicrm_id);

            if ($user_active and $tool_active){
                $signoff_values = [
                    "relationship_type_id"=> "11",
                    "contact_id_a" => $user->civicrm_id,
                    "contact_id_b" => $tool->civicrm_id,
                    "is_active" => "1",
                    "is_permission_a_b"=> "2",
                    "is_permission_b_a"=> "2",
                ];


                $api = new CiviApi();

                $result = $api->Relationship->Create($signoff_values);

                $signoff->civicrm_id = $result->id;
                $signoff->not_migrated =0;
                $signoff->save();

            }
            else{

                $signoff->transfer =0; // this does not have a group or user to hook it to
                $signoff->save();

            }
        }

/*        "contact_id_a": "2",
            "contact_id_b": "5037",
            "relationship_type_id": "11",
            "start_date": "2019-12-01",
            "is_active": "1",
            "is_permission_a_b": "2",
            "is_permission_b_a": "2"*/
    }
}
