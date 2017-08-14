<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Support\Facades\Log;

use App\Person;



class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $person = Person::where('boss_id',0)->first();
        return view('list')->withPerson($person);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $people = Person::orderBy('first_name', 'asc')->get();
        return view('form')->withPeople($people);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->storePerson($request,null);
        return redirect()->back()->with('message', 'Sikeres felvétel')->withInput($request->input());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $people = Person::orderBy('last_name', 'asc')->get();
        $updatedperson = Person::find($id);
        return view('form')->withPeople($people)->withUpdatedperson($updatedperson);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->storePerson($request,$id);
        return redirect()->back()->with('message', 'Sikeres módosítás');      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //dd($request->id." ".$id);
        $person = Person::find($request->id);
        File::delete($person->big_image, $person->small_image);
        $person->delete();
    }

    private function storePerson(Request $request, $id){
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|max:12',
            'image' => 'image'
        ]);
        if($id == null){
            $person = new Person;
            if($request->boss_id != null){
                $person->boss_id = $request->boss_id; 
            } else{
                $person->boss_id = 0;
            }            
        } else {
            $person = Person::find($id);
        }
        $person->last_name = $request->last_name;
        $person->first_name = $request->first_name;
        $person->email = $request->email;
        $person->website = $request->website;
        $person->phone = $request->phone;
        if($request->hasFile('image')){
            if($person->big_image != null && $person->small_image !=null){
                File::delete($person->big_image, $person->small_image);
            }
            $image = $request->file('image')->getRealPath();
            $image_name = $request->file('image')->getClientOriginalName();
            list($width, $height) = getimagesize($image);
            $image_big = Image::make($image);
            $image_big->orientate();
            if($width > 800 || $height>600){
                $image_big->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                }); 
            }
            $image_small = Image::make($image);  
            $image_small->orientate();
            $image_small->resize(100, 100);
            
            $rand = rand(1000,9999).time(); //more collision safety;
            $image_big->save("uploads/big-".$rand.$image_name);
            $person->big_image = "uploads/big-".$rand.$image_name;
            $image_small->save("uploads/small-".$rand.$image_name);
            $person->small_image = "uploads/small-".$rand.$image_name;
        }
        $person->save();
    }    


    public function countsublatern(Request $request){
        return Person::find($request->id)->subalterns()->count();
    }
}
