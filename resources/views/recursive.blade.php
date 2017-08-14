
<li id="li-{{ $person->id }}">
<div class="row row-person">
@if($person->small_image != null)
      <img id="img-{{ $person->id }}" role="button" data-toggle="modal" data-target="#showBigImage" data-pesron_big_image="{{ $person->big_image }}" data-person_name="{{ $person->first_name }} {{ $person->last_name }}" id="image-{{ $person->id }}" src="{{ URL::to('/') }}/{{$person->small_image }}" class="smallimage col-sm-2 img-responsive">
    

@endif
<div class="col-sm-10 col-xs-12"> 
<h4 class="list-group-item-heading">{{ $person->last_name }} {{ $person->first_name }}</h4>
  <div class="list-group-item-text"> 
    
    <p><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> 
    <a href="mailto:{{ $person->email }}">{{ $person->email }}</a>
    </p>
    <p>
    <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
    {{ $person->phone }}
    </p>
    @if($person->website!=null)
    <p>
      <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
      <a href="{{$person->website}}">{{ $person->website }}</a> 
    </p>
    @endif
    
    
    <a class="btn btn-success btn-person" href="{{ route('person.edit', $person->id) }}">Módosít</a>
            @if(!$person->subalterns->count())   
     
            <button class="btn btn-danger btn-person" role="button" data-toggle="modal" data-target="#confirmDelete"
            data-pesron_id="{{ $person->id }}" data-person_name="{{ $person->last_name }} {{ $person->first_name }}" 
            data-pesron_boss_id="{{ $person->boss_id }}"
            >Töröl</button>
           

            @else
                <button class="btn btn-danger btn-person" id="del-{{ $person->id }}" role="button" data-toggle="modal" data-target="#confirmDelete"
            data-pesron_id="{{ $person->id }}" data-person_name="{{ $person->last_name }} {{ $person->first_name }}"
            data-pesron_boss_id="{{ $person->boss_id }}" style="display: none;" 
            >Töröl</button>
            @endif
            @if($person->big_image != null && $person->small_image != null)
            <button class="btn btn-primary btn-photo btn-person" id="btn-{{ $person->id }}">Kép törlése</button>              
            @endif

</div>  
</div>
</div>
@if($person->subalterns->count())
  <ul class="ul-person">               
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
        <h3 class="modal-title">Biztos törli <span id="pName"></span>-t?</h3>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" id="delete">Igen</button>
        <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Nem</button>
      </div>
    </div>

  </div>
</div>

<div id="showBigImage" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg modal-image">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><span id="pName"></span></h3>
      </div>
      <div id="bigimagediv" class="modal-body">
        <img src="" id="imagepreview" class="img-responsive">
      </div>
    </div>

  </div>
</div>
