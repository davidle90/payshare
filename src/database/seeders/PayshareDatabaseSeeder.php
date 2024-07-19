<?php

namespace Davidle90\Payshare\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Davidle90\Payshare\app\Models\Contributor;
use Davidle90\Payshare\app\Models\Group;
use Davidle90\Payshare\app\Models\Member;
use Davidle90\Payshare\app\Models\Payment;
use Illuminate\Database\Seeder;

class PayshareDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $group = Group::create(['name' => 'Japan Travel Group']);

        $member1 = Member::create(['name' => 'David', 'group_id' => $group->id]);
        $member2 = Member::create(['name' => 'Marcus', 'group_id' => $group->id]);
        $member3 = Member::create(['name' => 'Nicholas', 'group_id' => $group->id]);

        $payment1 = Payment::create(['label' => 'Train Tickets', 'date' => '2023-06-21', 'total' => 240, 'group_id' => $group->id]);
        $payment2 = Payment::create(['label' => 'Sushi', 'date' => '2023-06-12', 'total' => 330, 'group_id' => $group->id]);
        $payment3 = Payment::create(['label' => 'Petrol', 'date' => '2023-06-16', 'total' => 420, 'group_id' => $group->id]);
        $payment4 = Payment::create(['label' => 'Bowling', 'date' => '2023-06-14', 'total' => 180, 'group_id' => $group->id]);

        // Attach participants to payments
        $payment1->participants()->attach([$member1->id, $member2->id, $member3->id]);
        $payment2->participants()->attach([$member1->id, $member2->id, $member3->id]);
        $payment3->participants()->attach([$member1->id, $member3->id]);
        $payment4->participants()->attach([$member1->id, $member2->id, $member3->id]);

        // Attach contributors to payments
        Contributor::create(['payment_id' => $payment1->id, 'member_id' => $member2->id, 'amount' => 240]); // Marcus
        Contributor::create(['payment_id' => $payment2->id, 'member_id' => $member3->id, 'amount' => 330]); // Nicholas
        Contributor::create(['payment_id' => $payment3->id, 'member_id' => $member1->id, 'amount' => 420]); // David
        Contributor::create(['payment_id' => $payment4->id, 'member_id' => $member2->id, 'amount' => 180]); // Marcus
    }
}
