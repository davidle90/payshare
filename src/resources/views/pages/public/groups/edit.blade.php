@extends('layouts.app')

@section('styles')
@endsection

@section('modals')
    @if(isset($group))
        @include('payshare::pages.public.groups.modals.delete', ['group' => $group])
    @endif
@endsection

@section('breadcrumbs')
@endsection

@php
@endphp

@section('content')
    <div class="container mx-auto">
        <div class="w-4/5 mx-auto py-12 my-5">
            <h1 class="text-center">@if(isset($group)) {{ $group->name }} @else Create @endif</h1>

            <a href="{{ route('payshare.index') }}" class="border px-3 py-1"><i class="fa-solid fa-arrow-left mb-5"></i> Back</a>

            <form id="onSaveForm" method="POST" action="{{ route('payshare.groups.store') }}" class="max-w-sm" autocomplete="off">

                @csrf
    
                <input type="hidden" name="id" value="{{ $group->id ?? '' }}">
    
                <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-200">Name</label>
                    <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ $group->name ?? '' }}">
                </div>
            </form>
    
            <ul class="flex text-gray-900">
                <li class="mb-5 mr-2">
                    <button class="onSave block text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                        Save
                    </button>
                </li>
                @if(isset($group))
                    <li class="mb-5">
                        <button data-modal-target="groupDeleteModal" data-modal-toggle="groupDeleteModal" class="block text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
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