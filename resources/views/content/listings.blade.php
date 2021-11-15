@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">

            @foreach($listings as $listing)
                <div class="col-md-4">

                    <div class="plan">
                        <div class="card">
                            <div class="card-header"><h3 class="text-center">{{ $listing->title }}</h3></div>

                            <div class="card-body">

                                {!! $listing->content !!}

                                <br>

                                <strong>{{ $listing->listing_plan->plan->name }}</strong>

                            </div>
                        </div>
                    </div>

                </div>
            @endforeach



        </div>
    </div>
@endsection
