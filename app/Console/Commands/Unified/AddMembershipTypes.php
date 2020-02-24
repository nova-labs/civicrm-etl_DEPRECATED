<?php

namespace App\Console\Commands\Unified;

use App\Logging;
use Illuminate\Console\Command;
use Leanwebstart\CiviApi3\CiviApi;

class AddMembershipTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm-unified:AddMembershipTypes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Membership types - Full, Associate';

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
        $membership_type_values = [
            "name"=> "Full Member",
            "member_of_contact_id"=> "1",
            "financial_type_id"=> "2",
            "duration_unit"=> "month",
            "duration_interval"=> "1",
            "period_type"=> "rolling",
            "visibility"=> "Public",
            "auto_renew"=> "2",
            "is_active"=> "1",
            "contribution_type_id"=> "2",
        ];

        $this->AddMembershipType($membership_type_values);

        $membership_type_values = [
            "name"=> "Associate",
            "member_of_contact_id"=> "1",
            "financial_type_id"=> "2",
            "duration_unit"=> "month",
            "duration_interval"=> "1",
            "period_type"=> "rolling",
            "visibility"=> "Public",
            "auto_renew"=> "2",
            "is_active"=> "1",
            "contribution_type_id"=> "2"
        ];

        $this->AddMembershipType($membership_type_values);

    }

    public function AddMembershipType($membership_type_values){

        $api = new CiviApi();

        $existing = $api->MembershipType->Get(['name' => $membership_type_values['name'] ]);

        if ($existing->count == 0){
            $result = $api->MembershipType->Create($membership_type_values);
            $this->logResults('Added Membership Type: with id:' . $result . ' for name: ' . $membership_type_values['name'],
                '', true);
        }
        else
        {
            $this->logResults('Skipping Membership Type with name: ' . $membership_type_values['name'],
                '', true);
        }
    }

    public function logResults($text, $error, $success){

        $log = Logging::create([
            'message' => $text,
            'error' => $error,
            'success' => $success,
        ]);
    }
}
