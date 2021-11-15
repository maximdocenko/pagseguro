@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-warning" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="row justify-content-center">

            @foreach($plans as $plan)
                <div class="col-md-4">
                    <div class="plan">
                        <div class="card">
                            <div class="card-header"><h3 class="text-center">{{ $plan->name }}</h3></div>

                            <div class="card-body">

                                <p>{{ $plan->type }}</p>
                                <p>$<strong>{{ $plan->price }}</strong></p>

                                <form method="POST" action="{{ url('select-plan', $plan->id) }}">
                                    @csrf
                                    <input type="submit" class="btn btn-success" value="Select">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
