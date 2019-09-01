@extends('layouts.app')

@section('title', 'Customer List')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Customer List</h1>
            <p><a href="/customers/create">Add New Customer</a></p>
        </div>
    </div>

    @foreach($customers as $item)
        <div class="row">
            <div class="col-2">
                {{ $item->id }}
            </div>
            <div class="col-4">
                <a href="/customers/{{ $item->id }}"> {{ $item->name }}</a>
            </div>
            <div class="col-4">
                {{ $item->company->name }}
            </div>
            <div class="col-2">
                {{ $item->active}}
            </div>
        </div>
    @endforeach()

    <div class="row">
        <div class="col-12 d-flex justify-content-center pt-5">
            {{ $customers->links() }}
        </div>
    </div>

@endsection

