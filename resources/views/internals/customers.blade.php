@extends('layout')

@section('title', 'Customer List')

@section('content')


    <div class="row">
        <div class="col-12"><h1>Customer List</h1></div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="customers" method="POST" class="">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                    <div>{{ $errors->first('name') }}</div>
                </div>

                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}">
                    <div>{{ $errors->first('email') }}</div>
                </div>

                <button type="submit" class="btn btn-primary">Add Customer</button>

                @csrf
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <ul>
                @foreach ($customers as $item)
                    <li> {{ $item->name }} <span class="">({{ $item->email }})</span></li>
                @endforeach
            </ul>
        </div>
    </div>






@endsection

