<?php

namespace App\Console\Commands\Unified;

use App\Logging;
use App\TransferGroup;
use App\TransferGroupUser;
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
    protected $signature = 'civicrm-unified:AddUsers {rounds=-1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Users along with their sign offs, Stripe subscriptions, Membership, and Family';

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
        // default to a limited number of user per round
        $rounds = (int) $this->argument('rounds');
        if ($rounds == -1 )
            $users_per_rounds = config('migration.users_per_round');
        else
            $users_per_rounds = $rounds;


        $transfer_users = TransferUser::where('transfer', 1)->where('not_migrated',1)->limit($users_per_rounds)->get();

        $bar = $this->output->createProgressBar(count($transfer_users));
        $bar->start();

        foreach ($transfer_users as $transfer_user) {

            $name = explode(' ', $transfer_user->name);

            $first_name = $last_name = $middle_name ='';

            $fix_name = 0;

            switch (count($name)) {
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

            $signoff_result = $this->addSignOffs($transfer_user->id, $result->id);

            $membership_result = $this->addMembership($transfer_user->civicrm_id);

            $this->logResults('User added: ' . $transfer_user->name . ' with id:' . $result->id
            . ' and ' . $signoff_result . ' signoffs and membership id:' . $membership_result, '', true);

            $bar->advance();

        }
    }

    public function addSignOffs($user_id,$user_civicrm_id){
        $signoffs = TransferGroupUser::where('transfer', 1)->where('not_migrated',1)
            ->where('user_id',$user_id)->get();

        $signoff_count = 0;

        foreach($signoffs as $signoff){

            $tool = TransferGroup::where('id', $signoff->group_id )->first();
            $tool_active = ($tool && $tool->civicrm_id);

            if ($tool_active){
                $signoff_values = [
                    "relationship_type_id"=> "11",
                    "contact_id_a" => $user_civicrm_id,
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
                $signoff_count++;
            } else {
                $signoff->transfer =0; // this does not have a group or user to hook it to
                $signoff->save();
            }
        }
        return($signoff_count);
    }

    public function addMembership($user_civicrm_id){

        $membership_types = config('migration.membership_types');

        $member = TransferUser::where('civicrm_id', $user_civicrm_id)
            ->first();

        $array_index = array_search($member->member_type, $membership_types);

        if($array_index && $membership_types[$member->member_type] == 'subscription'){
                // subscription implies that user needs a membership

            $member_type = '';

            if ($member->member_type == 'Member')
                $member_type = 'Full Member';

            if ($member->member_type == 'Associate')
                $member_type = 'Associate';

            $membership_values = [
                "membership_type_id" => $member_type,
                "contact_id" => $member->civicrm_id,
            ];

            if ($member_type && !$member->not_migrated) {

                $api = new CiviApi();

                $result = $api->Membership->Create($membership_values);

                $member->civicrm_member_id = $result->id;
                $member->save();

                return($result->id);
            }
        }
    }

    public function addSubscription($relationship_info){}

    public function addFamily($relationship_info){}

    public function addSponsor($relationship_info){}

    public function logResults($text, $error, $success){

        $log = Logging::create([
            'message' => $text,
            'error' => $error,
            'success' => $success,
        ]);
    }
}
