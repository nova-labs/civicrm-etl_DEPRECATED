<?php

namespace App\Console\Commands;

use App\TransferUser;
use Illuminate\Console\Command;
use Leanwebstart\CiviApi3\CiviApi;

class AddUserTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:AddUserTestAPI';

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

        $transfer_users = TransferUser::get();

        //dd(count($transfer_users));

        $count = 0;

        foreach ($transfer_users as $transfer_user) {
            $name = explode(' ', $transfer_user->name);
            $first_name = $name[0];
            if (count($name) > 1)
                $last_name = $name[1];
            else
                $last_name = '';

            //dd($name);

            $user_input = [
                'contact_type' => "Individual",
                'display_name' => $transfer_user->name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $transfer_user->email,
            ];


            $api = new CiviApi();


            $result = $api->Contact->Create($user_input);

            $count++;
            if ($count > 100)
                break;
        }

        echo $count;
    }
}

/*"contact_id": "2",
            "contact_type": "Individual",
            "contact_sub_type": "",
            "sort_name": "jhoskins98@gmail.com",
            "display_name": "jhoskins98@gmail.com",
            "do_not_email": "0",
            "do_not_phone": "0",
            "do_not_mail": "0",
            "do_not_sms": "0",
            "do_not_trade": "0",
            "is_opt_out": "0",
            "legal_identifier": "",
            "external_identifier": "",
            "nick_name": "",
            "legal_name": "",
            "image_URL": "",
            "preferred_communication_method": "",
            "preferred_language": "en_US",
            "preferred_mail_format": "Both",
            "first_name": "",
            "middle_name": "",
            "last_name": "",
            "prefix_id": "",
            "suffix_id": "",
            "formal_title": "",
            "communication_style_id": "1",
            "job_title": "",
            "gender_id": "",
            "birth_date": "",
            "is_deceased": "0",
            "deceased_date": "",
            "household_name": "",
            "organization_name": "",
            "sic_code": "",
            "contact_is_deleted": "0",
            "current_employer": "",
            "address_id": "",
            "street_address": "",
            "supplemental_address_1": "",
            "supplemental_address_2": "",
            "supplemental_address_3": "",
            "city": "",
            "postal_code_suffix": "",
            "postal_code": "",
            "geo_code_1": "",
            "geo_code_2": "",
            "state_province_id": "",
            "country_id": "",
            "phone_id": "",
            "phone_type_id": "",
            "phone": "",
            "email_id": "2",
            "email": "jhoskins98@gmail.com",
            "on_hold": "0",
            "im_id": "",
            "provider_id": "",
            "im": "",
            "worldregion_id": "",
            "world_region": "",
            "languages": "English (United States)",
            "individual_prefix": "",
            "individual_suffix": "",
            "communication_style": "Formal",
            "gender": "",
            "state_province_name": "",
            "state_province": "",
            "country": "",
            "id": "2"*/
