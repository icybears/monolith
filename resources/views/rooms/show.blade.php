<?php
use Illuminate\Support\Str;
?>
@extends('layouts.main')


@section('content')
<div class="container-fluid">
    <h1 class="h2">{{ $room->name ? $room->name : 'Room' . $room->id }}
           @if(!$room->name && Auth::id() == $room->user->id)
                <a href='{{ url("/room/$room->id/edit") }}' class="btn btn-sm btn-outline-primary">Set your room name</a>
            @endif
            @if(Auth::id() == $room->user->id )
                <a href='{{ url("/room/$room->id/edit") }}' class="btn btn-sm btn-primary float-right">Config Room</a>
            @endif
     </h1>
    <div class="row">
        <div class="col-6">
            <p>{{ $room->description ? $room->description : 'No description given yet' }}&nbsp;
                    @if(!$room->description && Auth::id() == $room->user->id)
                    <a href='{{ url("/room/$room->id/edit") }}' class="btn btn-sm btn-outline-primary">Describe your room</a>
                    @endif    
            </p>    
          
        </div>
    </div>
    
    <hr>
        @include('posts.create')
    <hr>
    <section>
        @if(count($room->posts))
            @foreach($room->posts()->orderBy('updated_at','desc')->get() as $post)
                @include('posts.post')
            @endforeach
        @else
            <h1 class="text-muted text-center font-weight-light"> Nothing posted here yet !</h1>
        @endif
    </section>
</div>
@endsection
