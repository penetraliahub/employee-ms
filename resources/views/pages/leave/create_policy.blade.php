@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <h1>Leave Policy
            <small>Create</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form autocomplete="off" novalidate="novalidate" role="form" id="submit_form" class="form-horizontal" method="POST" action="{{ route('leave-policy.store') }}">
                        @csrf
                        <div class="box-body">
                            @include('pages.leave.forms.policy')
                        </div>
                        <div class="box-footer">
                            <button id="button" type="submit" class="btn btn-success col-xs-2">Create</button>
                            <a type="button" class="btn btn-warning ml-3" href="{{route('leave-policy.index')}}" > Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop