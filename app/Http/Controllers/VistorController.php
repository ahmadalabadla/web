<?php

namespace App\Http\Controllers;

use App\Models\Vistor;
use Illuminate\Http\Request;

class VistorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vistors=Vistor::orderBy('id','desc');
        if ($request->get('search')) {
            $moduleIndex = Vistor::where('created_at', 'like', '%' . $request->search . '%');
        }

        if ($request->get('vistor_name')) {
            $vistors = Vistor::where('vistor_name', 'like', '%' . $request->vistor_name . '%');
        }
        if ($request->get('mobile')) {
            $vistors = Vistor::where('mobile', 'like', '%' . $request->mobile . '%');
        }
        if ($request->get('created_at')) {
            $vistors = Vistor::where('created_at', 'like', '%' . $request->created_at . '%');
        }
        if ($request->status != null) {
            $vistors = Vistor::where('status', $request->status);
        }
        $vistors = $vistors->paginate(10);
        return response()->view("dashboard.vistor.index",compact('vistors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view("dashboard.vistor.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valditor=validator($request->all(),[
            "vistor_name"=>'required|min:5'
        ]);
        if(!$valditor->fails()){
            $vistor=new Vistor();
            $vistor->vistor_name= $request->get('vistor_name');
            $vistor->mobile= $request->get('mobile');
            $vistor->date= $request->get('date');
            $vistor->status= $request->get('status');
            $vistor->location= $request->get('location');
            $vistor->replay= $request->get('replay');
            $vistor->replay_date= $request->get('replay_date');
            $vistor->description= $request->get('description');
            // $vistor->recepion_id= $request->get('recepion_id');
            $isSaved=$vistor->save();
            if($isSaved){
                return response()->json(['icon'=>'success','title'=>'???? ?????????? ???????????? ?????????? '],200);
            }else{
                return response()->json(['icon'=>'error','title'=>'???????? ?????????? ?????????? ????????????  '],400);

            }

        }else{
            return response()->json(['icon'=>'error','title'=>$valditor->getMessageBag()->first()],400);
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
        $vistors=Vistor::findOrFail($id);
        return response()->view('dashboard.vistor.edit',compact('vistors'));
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
        $valditor=validator($request->all(),[
            "vistor_name"=>'required|min:5'
        ]);
        if(!$valditor->fails()){
            $vistor= Vistor::findOrFail($id);
            $vistor->vistor_name= $request->get('vistor_name');
            $vistor->mobile= $request->get('mobile');
            $vistor->date= $request->get('date');
            $vistor->status= $request->get('status');
            $vistor->location= $request->get('location');
            $vistor->replay= $request->get('replay');
            $vistor->replay_date= $request->get('replay_date');
            $vistor->description= $request->get('description');
            // $vistor->recepion_id= $request->get('recepion_id');
            $isSaved=$vistor->save();
            return ['redirect'=>route('vistors.index')];
            if($isSaved){
                return response()->json(['icon'=>'success','title'=>'???? ?????????? ???????????? ?????????? '],200);
            }else{
                return response()->json(['icon'=>'error','title'=>'???????? ?????????? ?????????? ????????????  '],400);

            }

        }else{
            return response()->json(['icon'=>'error','title'=>$valditor->getMessageBag()->first()],400);
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
        $vistors=Vistor::destroy($id);
    }
}
