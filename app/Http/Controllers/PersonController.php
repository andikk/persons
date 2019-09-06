<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Person;
use App\Http\Resources\Person as PersonResource;

class PersonController extends Controller
{
    
    /**
     * List resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
      $persons = Person::All();
      return PersonResource::collection($persons);
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|max:255',
        'date' => 'required|date'
      ]);

      $data = $request->all();
      $person = new Person;
      $person->fill($data);
      if ($person->save()) {
        return new PersonResource($person);
      }
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|max:255',
        'date' => 'required|date'
      ]);

      $id = $request->input('id');
      $name = $request->input('name');
      $date = $request->input('date');
      $person = \App\Person::where('id', $id)->first();
      $person->name = $name;
      $person->date = $date;
      if ($person->save()) {
        return new PersonResource($person);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
      $person = \App\Person::where('id', $id)->first();
      if ($person->delete()) {
        return new PersonResource($person);
      };
    }
}
