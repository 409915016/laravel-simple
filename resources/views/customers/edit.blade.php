@extends('layouts.app')

@section('title', 'Edit Detail for'. $customer->name)

@section('content')


    <div class="row">
        <div class="col-12"><h1>Edit Detail for {{ $customer->name }}</h1></div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('customers.update', ['customer' => $customer]) }}" method="POST" class="">
                @method('PATCH')

                @include('customers.form')

                <button type="submit" class="btn btn-primary">Save Customer</button>
            </form>
        </div>
    </div>

@endsection

