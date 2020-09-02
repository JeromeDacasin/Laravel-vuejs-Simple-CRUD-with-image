<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contact::latest()->orderBy('created_at', 'desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $exploded = explode(',', $request->image);
        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg'))
            $extension ='jpg';
        else 
            $extension = 'png';

            $fileName = Str::random().'.'.$extension;

        $path = public_path().'./images/'.$fileName;

        file_put_contents($path, $decoded);

        $contact =Contact::create($request->all());

            return $contact;

      
                                 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Contact::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exploded = explode(',', $request->image);
        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg'))
            $extension ='jpg';
        else 
            $extension = 'png';

            $fileName = Str::random().'.'.$extension;

        $path = public_path().'./images/'.$fileName;

        file_put_contents($path, $decoded);

        Contact::findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Contact::destroy($id);
    }
}
