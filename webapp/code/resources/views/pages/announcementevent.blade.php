@extends('layouts.app')

@section('title', 'announcement_event')

@section('content')

    <section id="announcement_event">
        <h1>Add Announcement</h1>
        <form id="announcement_form" method="POST" action="{{ route('event.announcement', ['event_id' => $event_id]) }}">
            {{ csrf_field() }}
            <div class="form-group mt-3">
                <label for="announcement">Please write your message in this box...</label>
                <textarea id="announcement" form="announcement_form" name="announcement_message" class="form-control"
                    aria-label="With textarea" required></textarea>
            </div>
            <div class="text-center m-3"><button type="submit" class="btn btn-danger">Send</button></div>

        </form>
    </section>

@endsection
