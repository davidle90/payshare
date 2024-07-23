@extends('layouts.app')

@section('styles')
@endsection

@section('modals')
@endsection

@section('breadcrumbs')
@endsection

@section('content')
<div class="container mx-auto">
    <div class="w-4/5 mx-auto py-12 my-5">

       
        <div class="flex justify-between mb-5">
            <h2 class="text-2xl font-semibold">{{ $group->name }}</h2>
            <div>
                <span class="font-semibold">Members</span>
                <ul class="text-sm">
                    @foreach($members as $member)
                        <li>{{ $member->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex justify-between mb-3">
            <div>
                <a href="{{ route('payshare.index') }}" class="border px-3 py-1"><i class="fa-solid fa-arrow-left"></i> Back</a>
            </div>
            <div class="justify-end">
                <a href="{{ route('payshare.payments.create', ['group_id' => $group->id]) }}" class="border px-3 py-1"><i class="fa-solid fa-plus"></i> Add payment</a>
                <a href="{{ route('payshare.groups.edit', ['id' => $group->id]) }}" class="border px-3 py-1"><i class="fa-solid fa-gear"></i> Edit group</a>
                <a href="{{ route('payshare.members.create', ['group_id' => $group->id]) }}" class="border px-3 py-1"><i class="fa-solid fa-plus"></i> Add member</a>
            </div> 
        </div>
        

        <div class="relative overflow-x-auto rounded-lg mb-5">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Label</th>
                    <th scope="col" class="px-6 py-3">Contributors</th>
                    <th scope="col" class="px-6 py-3">Participants</th>
                    <th scope="col" class="px-6 py-3">Total</th>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr class="cursor-pointer bg-white border-b go-to-url" data-url="{{ route('payshare.payments.edit', ['group_id' => $group->id, 'payment_id' => $payment->id]) }}">
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($payment->created_at)->format('d M') }}</td>
                            <td class="px-6 py-4">{{ $payment->label }}</td>
                            <td class="px-6 py-4">
                                @foreach($payment->contributors as $contributor)
                                    {{ $contributor->member->name }} {{ $contributor->amount }}
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                @foreach($payment->participants as $participant)
                                    {{ $participant->name }} &nbsp;
                                @endforeach
                            </td>
                            <td class="px-6 py-4">{{ $payment->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="relative overflow-x-auto rounded-lg bg-white">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Repay</th>
                        @foreach($debts as $key => $debt)
                            <th scope="col" class="px-6 py-3">to {{ $key }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($debts as $from => $to)
                        <tr class="bg-white border-b">
                            <th class="px-6 py-4 text-xs text-gray-700 uppercase bg-gray-50">from {{ $from }}</th>
                            @foreach($debts[$from] as $to => $amount)
                                <td>
                                    {{ number_format($amount, 2, '.', ' ') }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="flex justify-between mt-5">
            <div>
                <div class="mb-2">Balance</div>
                @foreach($balance as $from => $to)
                    <div class="mb-2">
                        <span>{{ $from }}</span>
                        <ul>
                            @foreach($to as $m => $amount)
                                @if($amount != 0)
                                    <li>
                                        {{ $m }}: <span class="@if($amount < 0) text-red-600 @else text-green-600 @endif">{{ number_format($amount, 2, '.', ' ') }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            <div>
                <div class="mb-2">Currency Converter</div>
                
                <div class="mb-2">
                    <label for="from_currency">From</label>
                    <div>
                        <select class="text-gray-800" name="from_currency" id="from_currency">
                            <option value="SEK" selected>SEK</option>
                            <option value="SEK">EUR</option>
                            <option value="SEK">USD</option>
                            <option value="SEK">DDK</option>
                            <option value="SEK">NOK</option>
                            <option value="SEK">JPY</option>
                            <option value="SEK">KRW</option>
                            <option value="SEK">THB</option>
                        </select>
                    </div>
                    
                </div>

                <div class="mb-2">
                    <label for="to_currency">To</label>
                    <div>
                        <select class="text-gray-800" name="to_currency" id="to_currency">
                            <option value="SEK">SEK</option>
                            <option value="SEK" selected>EUR</option>
                            <option value="SEK">USD</option>
                            <option value="SEK">DDK</option>
                            <option value="SEK">NOK</option>
                            <option value="SEK">JPY</option>
                            <option value="SEK">KRW</option>
                            <option value="SEK">THB</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-2">
                    <label for="amount">Amount:</label>
                    <div>
                        <input type="number" id="amount" name="amount" />
                    </div>
                </div>

                <button type="button" class="px-3 py-2 border bg-orange-600">Convert</button>

                <div class="my-2">
                    <span>Result:</span>
                    <div>
                        <span class="conversion_result"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('payshare::includes.scripts.go-to-url')
@endsection