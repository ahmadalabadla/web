<?php

namespace App\Http\Controllers;

use App\Exports\TrainerExport;
use App\Models\City;
use App\Models\Diploma;
use App\Models\Group;
use App\Models\Trainer;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trainers=Trainer::withCount('trainerEvaluations')->with('user')->orderBy('id','desc');
       

        if ($request->get('email')) {
            $trainers = Trainer::where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->get('first_name')) {
            $trainers = Trainer::where('first_name', 'like', '%' . $request->first_name . '%');
        }
        if ($request->get('created_at')) {
            $trainers = Trainer::where('created_at', 'like', '%' . $request->created_at . '%');
        }
        if ($request->status != null) {
            $trainers = Trainer::where('status', $request->status);
        }
        $trainers = $trainers->paginate(10);
        return response()->view('dashboard.trainer.index',compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities=City::all();
        $diplomas=Diploma::all();
        return response()->view('dashboard.trainer.create',compact('cities','diplomas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validetor=validator($request->all(),[
            // 'email'=>'required|email',
            // 'password'=>'required|min:5',
        ]);
        if(!$validetor->fails()){
            $trainers=new Trainer();
            $trainers->email = $request->get('email');
            $trainers->password = Hash::make($request->get('password'));
            $trainers->diploma_id = $request->get('diploma_id');

            if (request()->hasFile('file')) {

            $file = $request->file('file');

            $fileName = time() . 'file.' . $file->getClientOriginalExtension();

            $file->move('storage/files/trainer', $fileName);

            $trainers->file = $fileName;
        }

            if (request()->hasFile('cv')) {

            $cv = $request->file('cv');

            $cvName = time() . 'cv.' . $cv->getClientOriginalExtension();

            $cv->move('storage/cv/trainers', $cvName);
            $trainers->cv = $cvName;
            }

            $isSave=$trainers->save();
            if($isSave){

            $users=new User();

            $users->first_name = $request->get('first_name');
            $users->last_name = $request->get('last_name');
            $users->mobile = $request->get('mobile');
            $users->date_of_birth = $request->get('date_of_birth');
            $users->salary_type = $request->get('salary_type');
            $users->salary_value = $request->get('salary_value');
            $users->speciality = $request->get('speciality');
            $users->job_title = $request->get('job_title');
            $users->certification = $request->get('certification');
            $users->city_id = $request->get('city_id');
            $users->actor()->associate($trainers);
            $isSave=$users->save();
            return response()->json(['icon'=>'success','title'=>'???? ?????????? ?????????? ???????????? ?????????? '],200);
            }else{
                return response()->json(['icon'=>'error','title'=>'???????? ?????????? ?????????? ????????????  '],400);

            }
        }else{
            return response()->json(['icon'=>'error','title'=>$validetor->getMessageBag()->first()],400);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trainers = Trainer::findOrFail($id);
        $cities = City::all();
        $diplomas=Diploma::all();
        return response()->view('dashboard.trainer.show',compact('trainers' , 'cities','diplomas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trainers= Trainer::findOrFail($id);
        $cities=City::all();
        $diplomas=Diploma::all();
        return response()->view('dashboard.trainer.edit',compact('trainers','cities','diplomas'));
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
        $validetor=validator($request->all(),[
            'email'=>'required|email',
        ]);
        if(!$validetor->fails()){
            $trainers=Trainer::findOrFail($id);
            $trainers->email = $request->get('email');
            $trainers->diploma_id = $request->get('diploma_id');

            if (request()->hasFile('file')) {

            $file = $request->file('file');

            $fileName = time() . 'file.' . $file->getClientOriginalExtension();

            $file->move('storage/files/trainer', $fileName);

            $trainers->file = $fileName;
        }

            if (request()->hasFile('cv')) {

            $cv = $request->file('cv');

            $cvName = time() . 'cv.' . $cv->getClientOriginalExtension();

            $cv->move('storage/cv/trainers', $cvName);
            $trainers->cv = $cvName;
            }
            $isSave=$trainers->user;
            if($isSave){
                $users=new User();
            $users->first_name = $request->get('first_name');
            $users->last_name = $request->get('last_name');
            $users->mobile = $request->get('mobile');
            $users->date_of_birth = $request->get('date_of_birth');
            $users->salary_type = $request->get('salary_type');
            $users->salary_value = $request->get('salary_value');
            $users->speciality = $request->get('speciality');
            $users->job_title = $request->get('job_title');
            $users->certification = $request->get('certification');
            $users->city_id = $request->get('city_id');
            $users->actor()->associate($trainers);
            $isSave=$users->save();
            return ['redirect' =>route('trainers.index')];

            return response()->json(['icon'=>'success','title'=>'???? ?????????? ?????????? ???????????? ?????????? '],200);
            }else{
                return response()->json(['icon'=>'error','title'=>'???????? ?????????? ?????????? ????????????  '],400);

            }
        }else{
            return response()->json(['icon'=>'error','title'=>$validetor->getMessageBag()->first()],400);

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
        $trainers=Trainer::destroy($id);
    }


    public function getStudent()
    {
        $students = Trainer::select('id' , 'first_name', 'last_name' , 'mobile' , 'salary_type', 'salary_value')->get()->toArray();
        return $students;
    }

    public function export()
    {
        return Excel::download(new TrainerExport, 'courses.xlsx');
    }
}
