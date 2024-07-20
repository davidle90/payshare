@extends('layouts.app')

@section('styles')
@endsection

@section('modals')
    @if(isset($payment))
        @include('payshare::pages.public.payments.modals.delete', ['payment' => $payment])
    @endif
@endsection

@section('breadcrumbs')
@endsection

@php
@endphp

@section('content')
    <div class="container mx-auto">
        <div class="w-4/5 mx-auto py-12 my-5">
            <h1 class="text-center">@if(isset($payment)) {{ $payment->label }} @else Create @endif</h1>

            <a href="{{ route('payshare.groups.view', ['id' => $group->id]) }}" class="border px-3 py-1"><i class="fa-solid fa-arrow-left mb-5"></i> Back</a>

            <form id="onSaveForm" method="POST" action="{{ route('payshare.payments.store') }}" class="max-w-sm" autocomplete="off">

                @csrf

                <input type="hidden" name="id" value="{{ $payment->id ?? '' }}">
                <input type="hidden" name="group_id" value="{{ $group->id ?? '' }}">

                <div class="mb-5">
                    <label for="label" class="block mb-2 text-sm font-medium text-gray-200">Label</label>
                    <input type="text" id="label" name="label" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ $payment->label ?? '' }}">
                </div>
                
                <div class="mb-5">
                    <label for="contributors" class="block mb-2 text-sm font-medium text-gray-200">Contributors</label>
                    @foreach($group->members as $member)
                        <div class="flex items-center mb-4">
                            <input id="contributor-{{ $member->id }}" type="checkbox" @if(isset($payment) && in_array($member->id, $contributor_ids)) checked @endif name="contributors[member_ids][]" value="{{ $member->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="contributor-{{ $member->id }}" class="ms-2 text-sm font-medium text-gray-200">{{ $member->name }}</label>
                            <input type="number" id="amount-{{ $member->id }}" name="contributors[{{ $member->id }}][amount]" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-50 p-1 ml-2" value="{{ isset($payment) && array_key_exists($member->id, $contributors) ? $contributors[$member->id]['amount'] ?? 0 : 0 }}">
                        </div>
                    @endforeach
                </div>

                <div class="mb-5">
                    <label for="participants" class="block mb-2 text-sm font-medium text-gray-200">Participants</label>
                    @foreach($group->members as $member)
                        <div class="flex items-center mb-4">
                            <input id="participant-{{ $member->id }}" type="checkbox" @if(isset($payment) && in_array($member->id, $participant_ids)) checked @endif name="participants[]" value="{{ $member->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="participant-{{ $member->id }}" class="ms-2 text-sm font-medium text-gray-200">{{ $member->name }}</label>
                        </div>
                    @endforeach
                </div>
            </form>

            <ul class="flex text-gray-900">
                <li class="mb-5 mr-2">
                    <button class="onSave block text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                        Save
                    </button>
                </li>
                @if(isset($payment))
                    <li class="mb-5">
                        <button data-modal-target="paymentDeleteModal" data-modal-toggle="paymentDeleteModal" class="block text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                            Delete
                        </button>
                    </li>
                @endif
            </ul>
            <div class="action-message mt-3 d-flex">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('payshare::includes.scripts.form')
@endsection