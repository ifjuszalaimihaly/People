@extends('master')
@section('title')
Személyek listázása
@endsection
@section('content')
<div class="container" style="margin-top: 5em;">
	<div class="row">
		<div class="col-xs-12">        
            <ul>
                  @include('recursive', $person)                
            </ul>           
		</div>

</div>
</div>
@endsection