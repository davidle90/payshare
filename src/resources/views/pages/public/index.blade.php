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
        <h1 class="mb-4 text-2xl font-extrabold sm:text-4xl text-center">
            PayShare
        </h1>

        <div class="flex justify-between mb-2">
            <a href="{{ route('index') }}" class="border px-3 py-1"><i class="fa-solid fa-arrow-left"></i> Back</a>
            <a href="{{ route('payshare.groups.create') }}" class="border px-3 py-1"><i class="fa-solid fa-plus"></i> Add group</a>
        </div>
        
        <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            PayShare Group Name
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $group)
                        <tr class="go-to-url cursor-pointer bg-white border-b" data-url="{{ route('payshare.groups.view', ['id' => $group->id]) }}">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $group->name }}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('payshare::includes.scripts.go-to-url')
@endsection