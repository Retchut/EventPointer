@foreach ($participants as $participant)
    <li class="list-group-item" href="{{ url('/user/'.$participant->id) }}">
        {{ $participant->username }} 
    </li>
@endforeach

</ul>
