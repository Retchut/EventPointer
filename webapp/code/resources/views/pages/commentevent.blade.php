@extends('layouts.app')

@section('title', 'comment_event')

@section('content')

    <section id="comment_event">
        <h1>Add Comment</h1>
        <form id="comment_form" method="POST" action="{{ route('event.comment', ['event_id' => $event_id]) }}">
            {{ csrf_field() }}
            <div class="form-group mt-3">
                <label for="comment">Please write your message in this box...</label>
                <textarea id="comment" form="comment_form" name="comment_message" class="form-control"
                    aria-label="With textarea" required></textarea>
            </div>
            <div class="text-center m-3"><button type="submit" class="btn btn-danger">Send</button></div>

        </form>
    </section>

@endsection
