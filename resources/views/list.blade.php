@extends('master')
@section('title')
Személyek listázása
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-xs-12">        
            <ul>
            @if($person != null)
                  @include('recursive', $person)
            @else
            <h1>A listázáshoz vegyen fel személyeket!</h1>
            @endif                      
            </ul>           
		</div>

</div>
</div>
@endsection
@section("scripts")
<script type="text/javascript" src="{{ asset('/js/list.js') }}"></script>
@endsection