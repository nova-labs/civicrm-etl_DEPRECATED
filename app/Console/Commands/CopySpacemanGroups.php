<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use App\TransferGroup;
use App\LegacyGroups;
use App\LegacyPeople;

class CopySpacemanGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etl:GetSpacemanGroups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull all groups from Spaceman to ETL table';

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
        $max_local_group_id = DB::table('transfer_groups')->max('id');
        if (isset($max_local_group_id))
            $local_max = $max_local_group_id;
        else
            $local_max = 0;

        $new_legacy_groups = LegacyGroups::where('id', '>', $local_max)->get();

        $migration_group_count = 0;


        foreach ($new_legacy_groups as $legacy_group) {
            $this->addNewGroup($legacy_group);
            $migration_group_count++;

        }

        $legacy_group_count = LegacyGroups::count();

        echo 'Groups: ' . $legacy_group_count . ' migrated: ' . $migration_group_count . "\n";
    }

    public function addNewGroup($legacy_group)
    {
        $group = new TransferGroup();

        $group->id = $legacy_group->id;
        $group->category = $legacy_group->category;
        $group->description = $legacy_group->description;
        $group->name = $legacy_group->name;

        $group->save();
    }
}


