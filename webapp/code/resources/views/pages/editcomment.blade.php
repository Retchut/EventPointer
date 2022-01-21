@extends('layouts.app')

@section('title', 'edit_comment_event')

@section('content')

    <section id="edit_comment_event">
        <section id="remove_participants">
            <h1 class="p-2"> <a role="button" href="{{ url('/event/' . $event_id) }}"
                class="btn w-auto mx-3"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                  </svg></a>Edit Comment
        </h1>
        <form id="comment_form" method="POST" action="{{ route('comment.update', ['event_id' => $event_id, 'comment_id' => $comment_id]) }}">
            {{ csrf_field() }}
            <div class="form-group mt-3">
                <label for="comment_message">Please rewrite your message in this box...</label>
                <textarea id="comment_message" form="comment_form" name="comment_message" class="form-control" aria-label="With textarea" required>{{ $comment -> messagec }}</textarea>
            </div>
            <div class="m-3">
                <label for="formFileSm" class="form-label">Upload Photo</label>
                <input class="form-control form-control-sm" id="formFileSm" type="file"  name = "file">
              </div>
            <div class="text-center m-3"><button type="submit" class="btn btn-danger">Save Changes</button></div>

        </form>
    </section>

@endsection