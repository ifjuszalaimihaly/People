<li id="li-{{ $person->id }}">
<div class="row row-person">
@if($person->smallimage != null)
			<img role="button" data-toggle="modal" data-target="#showBigImage" data-pesron_big_image="{{ $person->bigimage }}" id="image-{{ $person->id }}" src="{{ URL::to('/') }}/{{$person->smallimage }}" class=" smallimage col-sm-2">
		

@endif

<div class="col-sm-8"> 
<h4 class="list-group-item-heading">{{ $person->first_name }} {{ $person->last_name }}</h4>
	<div class="list-group-item-text row">
		<div class="col-md-4"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> 
		<a href="mailto:{{ $person->email }}">{{ $person->email }}</a>
    </div>
		@if($person->website!=null)
    <div class="col-md-4">
			<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
			<a href="http://{{$person->website}}">{{ $person->website }}</a> 
    </div>
		@endif
    <div class="col-md-4">
		<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
		{{ $person->phone }}
    </div>
    
	</div>

	
	<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
    <a class="btn btn-success btn-person btn-block" href="{{ route('person.edit', $person->id) }}">Módosít</a>
  </div>
	@if(!$person->subalterns->count())
    <div class="col-md-4 col-sm-6 col-xs-12">
		<button class="btn btn-danger btn-person btn-block" role="button" data-toggle="modal" data-target="#confirmDelete"
			data-pesron_id="{{ $person->id }}" data-person_name="{{ $person->first_name }} {{ $person->last_name }}"	
		>Töröl</button>
		</div>
	@endif
  </div>
</div>
</div>
@if($person->subalterns->count())
	<ul class="list-group ul-person">               
		@foreach($person->subalterns as $person)
    		@include('recursive', $person)
		@endforeach
	</ul>    
@endif
</li>
{{csrf_field()}}
<div id="confirmDelete" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Biztos törli <span id="pName"></span>-t?</h4>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete">Igen</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Nem</button>
      </div>
    </div>

  </div>
</div>

<div id="showBigImage" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div id="bigimagediv" class="modal-body">
        <img src="" id="imagepreview">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>