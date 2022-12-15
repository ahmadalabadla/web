<?php

namespace App\Http\Controllers;

use App\Exports\CourseExport;
use App\Models\Course;
use App\Models\Diploma;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexCourse($id)
    {
        //
        $courses = Course::where('diploma_id', $id)->withCount('files')->orderBy('created_at', 'desc')->paginate(5);
        return response()->view('dashboard.course.index', compact('courses','id'));
    }

    public function createCourse($id)
    {
        $diplomas=Diploma::all();
        return response()->view('dashboard.course.create', compact('diplomas' , 'id'));
    }

    public function index(Request $request)
    {
        $courses=Course::withCount('files')->orderBy('id','desc');
        if ($request->get('search')) {
            $moduleIndex = Course::where('created_at', 'like', '%' . $request->search . '%');
        }

        if ($request->get('course_name')) {
            $courses = course::where('course_name', 'like', '%' . $request->course_name . '%');
        }
        if ($request->get('houres')) {
            $courses = course::where('houres', 'like', '%' . $request->houres . '%');
        }
        if ($request->get('created_at')) {
            $courses = course::where('created_at', 'like', '%' . $request->created_at . '%');
        }
        if ($request->status != null) {
            $courses = Course::where('status', $request->status);
        }
        $courses = $courses->paginate(10);
        return response()->view('dashboard.course.index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $diplomas=Diploma::all();
        return response()->view('dashboard.course.create',compact('diplomas'));
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
            // 'course_name' => 'required|string',
            // 'course_code' => 'required|namber',
        ]);
        if (!$validetor->fails()) {
            $courses=new Course();
            $courses->course_name=$request->get('course_name');
            $courses->course_code=$request->get('course_code');
            $courses->houres=$request->get('houres');
            $courses->start_date=$request->get('start_date');
            $courses->end_date=$request->get('end_date');
            $courses->diploma_id=$request->get('diploma_id');
            $isSave=$courses->save();
            if($isSave){
                return response()->json(['icon'=>'success','title'=>'تم اضافة الدورة بنجاح '],200);
            }else{
                return response()->json(['icon'=>'error','title'=>'فشلت اضافة الدورة  '],400);

            }
        }else{
            return response()->json(['icon'=>'error','title'=>$validetor->getMessageBag()->first()],200);

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
        $diplomas=Diploma::all();
        $courses=Course::findOrFail($id);
        return response()->view('dashboard.course.edit',compact('diplomas','courses'));
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
            // 'course_name' => 'required|string',
            // 'course_code' => 'required|namber',
        ]);
        if (!$validetor->fails()) {
            $courses=Course::findOrFail($id);
            $courses->course_name=$request->get('course_name');
            $courses->course_code=$request->get('course_code');
            $courses->houres=$request->get('houres');
            $courses->start_date=$request->get('start_date');
            $courses->end_date=$request->get('end_date');
            $courses->diploma_id=$request->get('diploma_id');
            $isSave=$courses->save();
            return ['redirect' =>route('courses.index')];

            if($isSave){
                return response()->json(['icon'=>'success','title'=>'تم تعديل المساق بنجاح '],200);
            }else{
                return response()->json(['icon'=>'error','title'=>'فشلت تعديل المساق  '],400);

            }
        }else{
            return response()->json(['icon'=>'error','title'=>$validetor->getMessageBag()->first()],200);

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
        $courses=Course::destroy($id);
    }

    public function getStudent()
    {
        $students = Course::select('id' , 'course_name' , 'course_code' , 'start_date', 'end_date')->get()->toArray();
        return $students;
    }

    public function export()
    {
        return Excel::download(new CourseExport, 'courses.xlsx');
    }
}
