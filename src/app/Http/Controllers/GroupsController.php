<?php namespace Davidle90\Payshare\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Davidle90\Payshare\app\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class GroupsController extends Controller
{
    public function view($id)
    {
        $group = Group::find($id);

        $members = $group->members;
        $payments = $group->payments()->with(['contributors', 'participants'])->orderBy('date', 'desc')->get();
        $debts = [];
        $balance = [];

        foreach ($members as $member) {
            foreach ($members as $participant) {
                $debts[$member->name][$participant->name] = 0;
            }
        }

        foreach ($payments as $payment) {
            foreach ($payment->contributors as $contributor) {
                $debt = $contributor->amount / $payment->participants->count();
                foreach ($payment->participants as $participant) {
                    if ($contributor->member_id != $participant->id) {
                        $debts[$participant->name][$contributor->member->name] += $debt;
                    } else {
                        $debts[$participant->name][$contributor->member->name] += 0;
                    }
                }
            }
        }

        foreach ($debts as $from => $debt) {
            foreach ($debt as $to => $amount) {
                if($from != $to){
                    if (!isset($balance[$from][$to])) {
                        $balance[$from][$to] = 0;
                    }
                    $balance[$from][$to] += ($debts[$to][$from] ?? 0) - $amount;
                }
            }
        }

        return view('payshare::pages.public.groups.view', [
            'group' => $group,
            'members' => $members,
            'payments' => $payments,
            'balance' => $balance,
            'debts' => $debts,
        ]);
    }
    
    public function create()
    {
        return view('payshare::pages.public.groups.edit', [
        ]);
    }

    public function edit($id)
    {
        $group = Group::find($id);
        return view('payshare::pages.public.groups.edit', [
            'group' => $group
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $input = [
            'id' => $request->input('id'),
            'name' => $request->input('name')
        ];

        DB::beginTransaction();

        try {
            
            $group = Group::firstOrNew(['id' => $input['id']]);
            $group->name = $input['name'];
            $group->save();

            DB::commit();

            $response = [
                'status' => 1,
                'message' => 'Group has been saved.',
                'redirect' => route('payshare.groups.edit', ['id' => $group->id])
            ];

        } catch(Exception $e) {

            DB::rollBack();

            $response = [
                'status' => 0,
                'message' => 'Something went wrong while saving group.'
            ];
        }

        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $id = $request->get('delete_id');
        $group = Group::find($id);

        $group->delete();

        return response()->json([
            'status' => 1,
            'redirect' => route('payshare.index')
        ]);
    }
}