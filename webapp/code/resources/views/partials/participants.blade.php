@foreach ($participants as $participant)
    <a href="{{ url('/user/' . $participant->id) }}">
        <li class="list-group-item">
            {{ $participant->username }}
        </li>
    </a>
@endforeach

</ul>
