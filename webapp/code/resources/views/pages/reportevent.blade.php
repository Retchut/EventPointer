@extends('layouts.app')

@section('title', 'editevent')

@section('content')

<section id="report_event">
    <h1>Report Event</h1>
    <div class="form-group mt-3">
        <label for="report">Write here</label>
        <textarea id="report"  class="form-control" aria-label="With textarea"></textarea>
    </div>
    <div class = "text-center m-3"><button type="button" class="btn btn-danger">Send</button></div>
</section>

@endsection