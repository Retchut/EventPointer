@extends('layouts.app')

@section('title', 'report_event')

@section('content')

    <section id="report_event">
        <h1>Report Event</h1>
        <form id="report_form" method="POST" action="{{ route('event.report', ['event_id' => $event_id]) }}">
            {{ csrf_field() }}
            <div class="form-group mt-3">
                <label for="report">Please write your message in this box...</label>
                <textarea id="report" form="report_form" name="report_message" class="form-control"
                    aria-label="With textarea" required></textarea>
            </div>
            <div class="text-center m-3"><button type="submit" class="btn btn-danger">Send</button></div>

        </form>

    </section>

@endsection
