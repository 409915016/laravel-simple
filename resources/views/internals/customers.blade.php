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
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    <div>{{ $errors->first('name') }}</div>
                </div>

                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                    <div>{{ $errors->first('email') }}</div>
                </div>

                <div class="form-group">
                    <label for="active">Status</label>
                    <select name="active" id="active" class="form-control">
                        <option value="" disabled>Select customer status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>

                </div>

                <div class="form-group">
                    <label for="company_id">Company</label>
                    <select name="company_id" id="company_id" class="form-control">
                        @foreach ($companies as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>

                </div>

                <button type="submit" class="btn btn-primary">Add Customer</button>

                @csrf
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <h3>Active Customers</h3>
            <ul>
                @foreach ($activeCustomers as $item)
                    <li> {{ $item->name }} <span class="text-muted">({{ $item->company->name }})</span></li>
                @endforeach
            </ul>
        </div>

        <div class="col-6">
            <h3>Inactive Customers</h3>
            <ul>
                @foreach ($inactiveCustomers as $item)
                    <li> {{ $item->name }} <span class="text-muted">({{ $item->company->name }})</span></li>
                @endforeach
            </ul>
        </div>


    </div>

    <div class="row">
        <div class="col-12">
            @foreach ($companies as $item)
                <h3> {{ $item->name }} </h3>

                <ul>
                    @foreach($item -> customers as $customer)
                        <li> {{ $customer->name }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>

@endsection

