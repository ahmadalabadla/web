<?php

namespace App\Http\Controllers;

use App\Models\Diploma;
use App\Models\Group;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;

class DiplomaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $diplomas = Diploma::withCount('files' ,'courses' , 'groups')->orderBy('id' , 'desc');




        if ($request->get('name')) {
            $diplomas = $diplomas->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->get('start_date')) {
            $diplomas = $diplomas->where('start_date', 'like', '%' . $request->start_date . '%');
        }
        if ($request->get('created_at')) {
            $diplomas = $diplomas->orWhere('created_at', 'like', '%' . $request->created_at . '%')->
            orWhere('created_at', 'like', '%' . $request->created_at . '%');
        }
        $diplomas = $diplomas->simplePaginate(5);

        return response()->view('dashboard.diploma.index' , compact('diplomas'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::all();
        return response()->view('dashboard.diploma.create' , compact('rooms') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(),[
            // 'name' => 'required|string',
            // 'status' => 'required|string|on:Active,Ready,Finshed',

        ]

    );
        if(! $validator->fails()){
            $diplomas = new Diploma();
            $diplomas->name = $request->get('name');
            $diplomas->trannig_type = $request->get('trannig_type');
            $diplomas->number_of_hours = $request->get('number_of_hours');
            $diplomas->start_date = $request->get('start_date');
            $diplomas->end_date = $request->get('end_date');
            $diplomas->degree = $request->get('degree');
            $diplomas->price = $request->get('price');
            $diplomas->currency = $request->get('currency');
            $diplomas->number_of_student = $request->get('number_of_student');
            $diplomas->description = $request->get('description');
            $diplomas->status = $request->get('status');
            $diplomas->speciality = $request->get('speciality');
            $diplomas->room_id = $request->get('room_id');

            $isSaved = $diplomas->save();

            if($isSaved){
                return response()->json(['icon' => 'success' , 'title' => '???? ?????????? ???????????????? ??????????'] , 200);

            }
            else{
                return response()->json(['icon' => 'error' , 'title' => '???????? ?????????? ????????????????'] , 400);
            }

        }

        else{
            return response()->json(['icon' => 'error' , 'title' => $validator->getMessageBag()->first()] , 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function showGroup($id)
    {
        $groups = Group::where('diploma_id' , $id)->withCount('students')->get();
        $diplomas = Diploma::all();
        $students = Student::all();
        return response()->view('dashboard.diploma.showGroups', compact('groups', 'diplomas', 'students' ,'id'));

    }

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
        $rooms = Room::all();
        $diplomas = Diploma::find($id);
        return response()->view('dashboard.diploma.edit' , compact('rooms' , 'diplomas'));
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
        $validator = Validator($request->all(),[
            // 'name' => 'required|string',
            // 'status' => 'required|string|on:Active,Ready,Finshed',

        ]

    );
        if(! $validator->fails()){
            $diplomas = Diploma::findOrFail($id);
            $diplomas->name = $request->get('name');
            $diplomas->trannig_type = $request->get('trannig_type');
            $diplomas->number_of_hours = $request->get('number_of_hours');
            $diplomas->start_date = $request->get('start_date');
            $diplomas->end_date = $request->get('end_date');
            $diplomas->degree = $request->get('degree');
            $diplomas->price = $request->get('price');
            $diplomas->currency = $request->get('currency');
            $diplomas->number_of_student = $request->get('number_of_student');
            $diplomas->description = $request->get('description');
            $diplomas->status = $request->get('status');
            $diplomas->speciality = $request->get('speciality');
            $diplomas->room_id = $request->get('room_id');

            $isSaved = $diplomas->save();
            return ['redirect' =>route('diplomas.index')];

            if($isSaved){
                return response()->json(['icon' => 'success' , 'title' => '???? ?????????? ???????????????? ??????????'] , 200);

            }
            else{
                return response()->json(['icon' => 'error' , 'title' => '???????? ?????????? ?????????? ????????????????'] , 400);
            }

        }

        else{
            return response()->json(['icon' => 'error' , 'title' => $validator->getMessageBag()->first()] , 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $diplomas = Diploma::destroy($id);
        return response()->json(['icon' => 'success' , 'title' => '???? ?????? ???????????????? ??????????'] , $diplomas ? 200 : 400);

    }
}
