@extends('master')
@section('title')
Személyek listázása
@endsection
@section('content')
	<div class="col-xs-12">        
            <ul>
                  @if($people != null)
                        @foreach($people as $person)
                              @include('recursive', $person)
                        @endforeach
                  @else
                        <h1>A listázáshoz vegyen fel személyeket!</h1>
                  @endif                      
            </ul>           
      </div>
@endsection
@section("scripts")
<script type="text/javascript" src="{{ asset('/js/list.js') }}"></script>
@endsection