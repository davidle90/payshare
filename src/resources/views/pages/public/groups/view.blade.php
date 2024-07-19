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

        <div class="flex justify-between mb-2">
            <h2 class="text-xl font-semibold">{{ $group->name }}</h2>
            <a href="" class="border px-3 py-1"><i class="fa-solid fa-plus"></i> Add member</a>
        </div>

        <div class="mb-5">
            <span class="font-semibold">Members</span>
            <ul class="text-sm">
                @foreach($members as $member)
                    <li>{{ $member->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-end mb-2">
            <a href="" class="border px-3 py-1"><i class="fa-solid fa-plus"></i> Add payment</a>
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
                        <tr class="cursor-pointer bg-white border-b">
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($payment->date)->format('d M') }}</td>
                            <td class="px-6 py-4">{{ $payment->label }}</td>
                            <td class="px-6 py-4">
                                @foreach($payment->contributors as $contributor)
                                    {{ $contributor->member->name }} {{ $contributor->amount }} kr
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                @foreach($payment->participants as $participant)
                                    {{ $participant->name }} &nbsp;
                                @endforeach
                            </td>
                            <td class="px-6 py-4">{{ $payment->total }} kr</td>
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
                        <tr class="cursor-pointer bg-white border-b">
                            <th class="px-6 py-4 text-xs text-gray-700 uppercase bg-gray-50">from {{ $from }}</th>
                            @foreach($debts[$from] as $to => $amount)
                                <td>
                                    {{ $amount }} kr
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-5">
            <div class="mb-2">Balance</div>
            @foreach($balance as $from => $to)
                <div class="mb-2">
                    <span>{{ $from }}</span>
                    <ul>
                        @foreach($to as $m => $amount)
                            <li>
                                {{ $m }}: <span class="@if($amount < 0) text-red-600 @else text-green-600 @endif">{{ $amount }} kr</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection