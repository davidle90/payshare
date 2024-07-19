<?php namespace Davidle90\Payshare\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Davidle90\Payshare\app\Models\Contributor;
use Davidle90\Payshare\app\Models\Group;
use Davidle90\Payshare\app\Models\Member;
use Davidle90\Payshare\app\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentsController extends Controller
{
    public function create($group_id)
    {
        $group = Group::find($group_id);
        return view('payshare::pages.public.payments.edit', [
            'group' => $group
        ]);
    }

    public function edit($group_id, $payment_id)
    {
        $payment = Payment::find($payment_id);
        $group = Group::find($group_id);
        $contributor_ids = $payment->contributors->pluck('id')->toArray();
        $participant_ids = $payment->participants->pluck('id')->toArray();

        return view('payshare::pages.public.payments.edit', [
            'group' => $group,
            'payment' => $payment,
            'contributor_ids' => $contributor_ids,
            'participant_ids' => $participant_ids
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required'
        ]);

        $input = [
            'id' => $request->input('id'),
            'group_id' => $request->input('group_id'),
            'label' => $request->input('label'),
            'contributors' => $request->input('contributors', []),
            'participants' => $request->input('participants', [])
        ];

        DB::beginTransaction();

        try {
        
            $payment = Payment::firstOrNew(['id' => $input['id']]);
            $payment->label = $input['label'];
            $payment->group_id = $input['group_id'];
            $payment->date = now();
            $payment->total = 0;
            $payment->save();

            foreach($input['contributors']['member_ids'] as $member_id){
                $contributor = Contributor::firstOrNew(['member_id' => $member_id, 'payment_id' => $payment->id]);
                $contributor->amount = $input['contributors'][$member_id]['amount'];
                $contributor->save();
            }

            $total = 0;
            foreach($payment->contributors as $contributor){
                $total += $contributor->amount;
            }

            $payment->total = $total;
            $payment->save();

            $payment->participants()->sync($input['participants']);

            DB::commit();

            $response = [
                'status' => 1,
                'message' => 'Payment has been saved.',
                'redirect' => route('payshare.groups.view', ['id' => $payment->group_id])
            ];

        } catch(Exception $e) {

            DB::rollBack();

            $response = [
                'status' => 0,
                'message' => 'Something went wrong while saving payment.'
            ];
        }

        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $id = $request->get('delete_id');
        $payment = Payment::find($id);
        $group_id = $payment->group_id;
        $payment->contributors()->delete();
        $payment->participants()->detach();
        $payment->delete();

        return response()->json([
            'status' => 1,
            'redirect' => route('payshare.groups.view', ['id' => $group_id])
        ]);
    }
}