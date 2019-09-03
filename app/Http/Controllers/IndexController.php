<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Person;

class IndexController extends Controller
{
  public function start () {
    return view('index');
  }

  public function list () {
    $persons = Person::select(['name','date','id'])->get();
    
    return response()->json([
      'persons' => $persons->toArray()
    ]);    
  }

  public function store(Request $request) {
    $this->validate($request, [
      'name' => 'required|max:255',
      'date' => 'required|date'
    ]);

    $data = $request->all();
    $person = new Person;
    $person->fill($data);
    $person->save();
  }

  public function delete($person) {
    $person_tmp = \App\Person::where('id', $person)->first();
    $person_tmp->delete();
  }

  public function update(Request $request) {
    $this->validate($request, [
      'name' => 'required|max:255',
      'date' => 'required|date'
    ]);

    $id = $request->input('id');
    $name = $request->input('name');
    $date = $request->input('date');
    $person_tmp = \App\Person::where('id', $id)->first();
    $person_tmp->name = $name;
    $person_tmp->date = $date;
    $person_tmp->save();
  }
}
