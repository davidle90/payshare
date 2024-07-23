<?php

namespace Davidle90\Payshare\App\Console\Commands;

use Davidle90\Payshare\app\Models\Group;
use Illuminate\Console\Command;

class ClearDemoData extends Command
{
    protected $signature = 'command:clear_demo_data';

    protected $description = 'clear demo data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $groups = Group::get();

        foreach($groups as $group)
        {
            foreach($group->payments as $payment){
                $payment->contributors()->delete();
                $payment->participants()->detach();
                $payment->delete();
            }
            
            $group->members()->delete();
            $group->delete();
        }
    }
}
