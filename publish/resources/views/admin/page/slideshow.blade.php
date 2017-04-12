@extends('fabric::admin.layouts.default')

@section('content')

    @include('fabric::admin.page.partials.tabs', ['tab' => 'slideshow'])

    <div class="panel panel-default has-tabs">
        @if(empty($slides))
            <div class="panel-body">
                <p class="lead text-center">
                    Coming Soon
                </p>
                {{--<p class="lead text-center">--}}
                    {{--You do not have a slideshow set up for this page.--}}
                {{--</p>--}}

                {{--<p class="text-center">--}}
                    {{--<button class="btn btn-default">Add Slide</button>--}}
                {{--</p>--}}
            </div>
        @endif
    </div>

@endsection