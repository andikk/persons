<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Person;

class IndexController extends Controller
{
  public function index () {
    $persons = Person::select(['name','date','id'])->get();

    return view('page')->with(['persons'=>$persons]);

  }


  public function store(Request $request) {

    $this->validate($request, [
      'name' => 'required|max:255',
      'date' => 'required'
    ]);

    $data = $request->all();
    $person = new Person;
    $person->fill($data);
    $person->save();
    return redirect('/');

  }

  public function delete($person) {
    $person_tmp = \App\Person::where('id', $person)->first();
    $person_tmp->delete();
    return redirect('/');
  }

  public function add() {
    return view('add');
  }

  public function edit($name, $date) {
    dump($name);
    dump($date);
    //return view('edit')->with(['person'=>$person]);

  }

  public function update($person) {

  }
}