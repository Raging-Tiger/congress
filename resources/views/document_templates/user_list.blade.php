<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
</head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>

{{-- Received: $event, $participants --}}
<div class="container">
    <div class="card">
        <div class="card-body">
            <p>
                Event name: {{$event->name}} <br>
                Duration: {{date('d-m-Y', strtotime($event->start_date))}} - {{date('d-m-Y', strtotime($event->end_date))}}
            </p>

            <table>
                participants          
                <tr>
                    <th>
                        No.
                    </th>
                    <th>
                        Participant
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        Participation type
                    </th>
                    <th>
                        Bill status
                    </th>
                </tr>
                {{-- User number counter --}}
                @php $user_index = 1; @endphp
                @foreach($participants as $participant)
                <tr>
                    <td>{{$user_index}}</td>
                    <td>
                        @if($participant->users->fullNames)
                        {{$participant->users->fullNames->title ?? ' '}}
                        {{$participant->users->fullNames->name}} {{$participant->users->fullNames->surname}} 
                        @else
                        {{$participant->users->companies->name}}
                        @endif
                    </td>
                    <td>{{$participant->users->roles->name}}</td>
                    <td>
                        @if($participant->users->billEvent($event->id)->total_cost_per_articles)
                            Article <br>
                        @endif
                        @if($participant->users->billEvent($event->id)->total_cost_per_participation)
                            Participation
                        @endif
                        @if($participant->users->billEvent($event->id)->total_cost_per_materials)
                            Materials
                        @endif
                    </td>
                    <td>
                        {{$participant->users->billEvent($event->id)->billStatuses->name}}
                    </td>
                    @php $user_index++; @endphp
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>



