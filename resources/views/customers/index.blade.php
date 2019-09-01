@extends('layouts.app')

@section('title', 'Customer List')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Customer List</h1>
        </div>
    </div>

    @can('create', App\Customer::class)
        <div class="row">
            <div class="col-12">
                <p><a href="{{ route('customers.create') }}">Add New Customer</a></p>
            </div>
        </div>
    @endcan

    @foreach($customers as $item)
        <div class="row">
            <div class="col-2">
                {{ $item->id }}
            </div>
            <div class="col-4">
                @can('view', $item)
                    <a href="{{ route('customers.show', ['customer' => $item]) }}">{{ $item->name }}</a>
                @endcan
                @cannot('view', $item)
                    {{ $item->name }}
                @endcannot
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

