<?php

namespace App\Console\Commands\Unified;

use App\Logging;
use Illuminate\Console\Command;
use Leanwebstart\CiviApi3\CiviApi;

class AddRelationships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm-unified:AddRelationships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Tool, Sponsor, Family Relationship';

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

        $tool_values = [
            'name' => "Tool",
            "label" => "Tool",
            'parent_id' => "1",
            'is_active' => "1",
        ];

        $result = $api->ContactType->Create($tool_values);

        //logging here

        $tool_relationship = [
            "name_a_b" => "Signed off on",
            "label_a_b" => "Signed off on",
            "name_b_a" => "Can be operated by",
            "label_b_a" => "Can be operated by",
            "description" => "Sign offs",
            "contact_type_b" => "Individual",
            "contact_sub_type_b" => "Tool",
            "is_active" => "1",
        ];

        $result = $api->RelationshipType->Create($tool_relationship);

        $log = Logging::create([
            'message' => 'Added Relationship: Signoff with id:' . $result,
            'success' => true,
        ]);

        $family_relationship = [
            "name_a_b" => "Family Primary for",
            "label_a_b" => "Family Primary for",
            "name_b_a" => "Is Family Member of",
            "label_b_a" => "Is Family Member of",
            "description" => "Primary Family Member",
            "is_active" => "1",
        ];

        $result = $api->RelationshipType->Create($family_relationship);

        $log = Logging::create([
            'message' => 'Added Relationship: Family Primary with id:' . $result,
            'success' => true,
        ]);

        $sponsor_relationship = [
            "name_a_b" => "Sponsored",
            "label_a_b" => "Sponsored",
            "name_b_a" => "Is Sponsored By",
            "label_b_a" => "Is Sponsored By",
            "description" => "Full Member Sponsorship",
            "is_active" => "1"
        ];

        $result = $api->RelationshipType->Create($sponsor_relationship);

        $log = Logging::create([
            'message' => 'Added Relationship: Sponsor with id:' . $result,
            'success' => true,
        ]);
    }
}
