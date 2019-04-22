{{Auth::user()->name}}
{{Auth::user()->description}}
@foreach($skills as $skill)
    <br>{{$skill->name}} level: {{$levels[$skill->id]}} xp: {{$xps[$skill->id]}}
    @endforeach