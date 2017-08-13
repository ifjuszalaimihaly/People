<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

use App\Person;

class ImageController extends Controller
{
    public function destroy(Request $request)
    {	
        $person = Person::find($request->id);
        File::delete($person->big_image, $person->small_image);
        $person->big_image = NULL;
        $person->small_image = NULL;
        $person->save();
    }
}
