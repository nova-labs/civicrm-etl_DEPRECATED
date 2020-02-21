<?php

namespace App\Console\Commands;

use App\TransferGroup;
use App\TransferGroupUser;
use App\TransferUser;
use Illuminate\Console\Command;
use Leanwebstart\CiviApi3\CiviApi;

class AddMemberships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:AddMemberships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add memberships ';

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
        $members = TransferUser::where('civicrm_id', '>', 0)
            ->where('member_type', 'Associate')
            ->orwhere('member_type', 'Member')
            ->get();

        $bar = $this->output->createProgressBar(count($members));
        $bar->start();

        foreach ($members as $member) {

            $member_type = '';

            if ($member->member_type == 'Member')
                $member_type = 'Full Member';

            if ($member->member_type == 'Associate')
                $member_type = 'Associate';

            $membership_values = [
                "membership_type_id" => $member_type,
                "contact_id" => $member->civicrm_id,
            ];

            if ($member_type && $member->migrated) {

                $api = new CiviApi();

                $result = $api->Membership->Create($membership_values);

                $member->civicrm_member_id = $result->id;
                $member->save();
            } else {
                //

            }
            $bar->advance();
        }
        $bar->finish();
    }
}
