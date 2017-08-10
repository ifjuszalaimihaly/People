<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManagerStatic as Image;

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
        $person = Person::where('id',1)->first();
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
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:people|email',
            'phone' => 'required|unique:people|max:12',
            'website' => 'nullable|unique:people'
        ]);

        $person = new Person;
        $person->boss_id = $request->boss_id;
        $person->last_name = $request->last_name;
        $person->first_name = $request->first_name;
        $person->email = $request->email;
        $person->website = $request->website;
        $person->phone = $request->phone;
        if($request->hasFile('image')){
            $image = $request->file('image')->getRealPath();
            $image_name = $request->file('image')->getClientOriginalName();
            list($width, $height) = getimagesize($image);
            $image_big = Image::make($image); 
            if($width > 800 || $height>600){
                if($width>800 && $height>600){
                    if($height>$width){
                        $image_big->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        $image_big->resize(600, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                }
                if($width>800 && $height<=600){
                    $image_big->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                if($width<=800 && $height>600){
                    $image_big->resize(null, 800, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

            }
            $image_big->save("uploads/big-".time().$image_name);
            $person->big_image = "uploads/big-".time().$image_name;
            $image_small = Image::make($image);              
            $image_small->resize(100, 100);
            $image_small->save("uploads/small-".time().$image_name);
            $person->small_image = "uploads/small-".time().$image_name;
        }
        $person->save();
        return redirect()->back()->with('message', 'Sikeres feltöltés');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
         $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|max:12'
        ]);
        $person = Person::find($id);
        $person->last_name = $request->last_name;
        $person->first_name = $request->first_name;
        $person->email = $request->email;
        $person->website = $request->website;
        $person->phone = $request->phone;
        if($request->hasFile('image')){
            File::delete($person->bigimage, $person->smallimage);
            $image = $request->file('image')->getRealPath();
            $image_name = $request->file('image')->getClientOriginalName();
            list($width, $height) = getimagesize($image);
            $image_big = Image::make($image); 
            if($width > 800 || $height>600){
                if($width>800 && $height>600){
                    if($height>$width){
                        $image_big->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        $image_big->resize(600, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                }
                if($width>800 && $height<=600){
                    //dd("width>800 && height<=600");
                    $image_big->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio(); //there are not downsize method
                    });
                }
                if($width<=800 && $height>600){
                    //dd("width<=800 && height>600");
                    $image_big->resize(null, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

            }
            $image_big->save("uploads/big-".time().$image_name);
            $person->big_image = "uploads/big-".time().$image_name;
            $image_small = Image::make($image);              
            $image_small->resize(100, 100);
            $image_small->save("uploads/small-".time().$image_name);
            $person->small_image = "uploads/small-".time().$image_name;
        }
        $person->save();
        return redirect()->back()->with('message', 'Sikeres módosítás');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //dd($request->id." ".$id);
        $person = Person::find($request->id);
        File::delete($person->big_image, $person->small_image);
        $person->delete();
    }



}
