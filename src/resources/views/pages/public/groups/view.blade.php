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

        <div class="flex justify-between mb-3 sm:mb-0">
            <div class="mb-4 sm:mb-4">
                <a href="{{ route('payshare.index') }}" class="border px-3 py-1"><i class="fa-solid fa-arrow-left"></i> Back</a>
            </div>
            <div class="sm:flex justify-end space-y-4 sm:space-y-0">
                <div>
                    <a href="{{ route('payshare.payments.create', ['group_id' => $group->id]) }}" class="border px-3 py-1"><i class="fa-solid fa-plus"></i> Add payment</a>
                </div>
                <div>
                    <a href="{{ route('payshare.groups.edit', ['id' => $group->id]) }}" class="border px-3 py-1"><i class="fa-solid fa-gear"></i> Edit group</a>
                </div>
                <div>
                    <a href="{{ route('payshare.members.create', ['group_id' => $group->id]) }}" class="border px-3 py-1"><i class="fa-solid fa-plus"></i> Add member</a>
                </div>
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
        
        <div class="sm:flex justify-between mt-5">
            <div class="mb-5">
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

            <form id="currencyConversionForm" method="POST" action="{{ route('payshare.exchangerateapi.convert') }}" autocomplete="off">
                <div class="mb-2">Currency Converter</div>
                
                <div class="mb-2">
                    <label class="block" for="from_currency">From</label>
                    <select class="text-gray-800 px-2 py-1" name="from_currency" id="from_currency">
                        <option value="SEK" selected>SEK</option>
                        <option value="EUR">EUR</option>
                        <option value="USD">USD</option>
                        <option value="DDK">DDK</option>
                        <option value="NOK">NOK</option>
                        <option value="JPY">JPY</option>
                        <option value="KRW">KRW</option>
                        <option value="THB">THB</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="block" for="to_currency">To</label>
                    <select class="text-gray-800 px-2 py-1" name="to_currency" id="to_currency">
                        <option value="SEK">SEK</option>
                        <option value="EUR" selected>EUR</option>
                        <option value="USD">USD</option>
                        <option value="DDK">DDK</option>
                        <option value="NOK">NOK</option>
                        <option value="JPY">JPY</option>
                        <option value="KRW">KRW</option>
                        <option value="THB">THB</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="amount" class="block">Amount</label>
                    <input type="number" id="amount" name="amount" class="text-gray-800">
                </div>

                <button type="button" class="px-3 py-2 border bg-orange-600 onConvert">Convert</button>

                <div class="my-2">
                    <span class="conversion_rate block"></span>
                    <span class="conversion_result block"></span>
                    <span class="error_message block"></span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('payshare::includes.scripts.go-to-url')
    <script>
        $(document).ready(function() {

            $('.onConvert').on('click', function() {
                
                let $form = $('#currencyConversionForm');
                let $formData = new FormData($('#currencyConversionForm')[0]);

                $.ajax({
                    url: $form.attr('action'),
                    method: $form.attr('method'),
                    data: $formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: 'json',
                    success: function (res) {
                        if(res.status == 1){
                            $('.conversion_rate').html(`<span>Conversion rate: ${res.conversion_rate}</span>`);
                            $('.conversion_result').html(`<span>Result: ${res.conversion_result}</span>`+' '+`<span>${res.currency}</span>`);
                            $('.error_message').empty();
                        } else if(res.status == 0) {
                            $('.conversion_rate').empty();
                            $('.conversion_result').empty();
                            $('.error_message').html(`<span class="text-red-600">${res.error_message}</span>`);
                        } else {
                        }
                    }
                })
            })
        })
    </script>
@endsection