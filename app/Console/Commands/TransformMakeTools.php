<?php

namespace App\Console\Commands;

use App\TransferGroup;
use Illuminate\Console\Command;

class TransformMakeTools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'civicrm_etl:MakeTools';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup groups for import';

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
        $groups = TransferGroup::all();

        foreach ($groups as $group){

            if (!substr_count($group->name,'retired'))
            {
                if (substr_count($group->name,'[equipment]')){
                    $group->tool_name = substr($group->name, 12);
                    $group->tool_type = '[equipment]';
                    $group->transfer = 1;
                }

                if (substr_count($group->name,'[novapass]')){
                    $group->tool_name = substr($group->name, 11);
                    $group->tool_type = '[novapass]';
                    $group->transfer = 1;
                }

                $group->save();
            }


        }
    }
}
