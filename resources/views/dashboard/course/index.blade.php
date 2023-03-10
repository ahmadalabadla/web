@extends('dashboard.parent')
@section('title','المساقات  ')

@section('left-title','عرض المساقات ')

@section('active title','عرض المساقات ')


@section('styles')
  <style>

</style>
@endsection

@section('content')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
              <h3 class="card-title"> عرض المساقات </h3>
              <div class="card-tools">
                <form action="" method="get" style="margin-bottom:2%;">
                    <div class="row">
                        <div class="input-icon col-md-2">
                            <input type="text" class="form-control" placeholder="بحث باسم المساق "
                               name='course_name' @if( request()->course_name) value={{request()->course_name}} @endif/>
                              <span>
                                  <i class="flaticon2-search-1 text-muted"></i>
                              </span>
                            </div>

                            <div class="input-icon col-md-2">
                            <input type="text" class="form-control" placeholder=" بحث بعدد الساعات المساق"
                               name='houres' @if( request()->houres) value={{request()->houres}} @endif/>
                              <span>
                                  <i class="flaticon2-search-1 text-muted"></i>
                              </span>
                            </div>

                            <div class="input-icon col-md-2">
                            <input type="date" class="form-control" placeholder="Search By Date"
                               name='created_at' @if( request()->created_at) value={{request()->created_at}} @endif/>
                              <span>
                                  <i class="flaticon2-search-1 text-muted"></i>
                              </span>
                            </div>

                    <div class="btn">
                          <button class="btn btn-success btn-md" type="submit">فلتر البحث</button>
                          <a href="{{route('courses.index')}}"  class="btn btn-danger">إنهاء البحث</a>
                          <a href="{{route('createCourse' , $id)}}"><button type="button" class="btn btn-primary">انشاء مساق جديدة </button></a>
                          <a href="{{route('course-exports-excel')}}"><button type="button" class="btn  btn-success">تصدير إكسيل </button></a>

                        </div>



                  </div>
            </form>
                {{-- <a href="{{route('createCourse' , $id)}}"><button type="button" class="btn btn-lg btn-primary">انشاء مساق جديدة </button></a> --}}
              </div>
              <br>
            </div>

          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered table-striped text-nowrap text-center">
              <thead>
                <tr class="bg-info">
                  <th> رقم الدورة </th>
                  <th>  اسم الدورة </th>
                  <th>  عدد ساعات الدورة  </th>
                  <th>  الملفات   </th>
                  <th>  موعد بداية الدورة  </th>
                  <th>  موعد نهاية الدورة </th>

                  <th> الاعدادات </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($courses as $course )
                <tr>
                  <td>{{$course->id}}</td>
                  <td>{{$course->course_name}}</td>

                  <td>{{$course->houres}}</td>
                  <td><a href="{{route('indexCFile',['id'=>$course->id])}}"
                    class="btn btn-info">({{$course->files_count}})
                    الملفات</a> </td>
                  <td>{{$course->start_date}}</td>
                  <td>{{$course->end_date}}</td>
                  <td>
                    <div class="btn-course">
                      <a href="{{route('courses.edit',$course->id)}}" class="btn btn-info" title="Edit">
                        تعديل
                        </a>

                      <a href="#" onclick="performDestroy({{$course->id}}, this)" class="btn btn-danger" title="Delete">
                        حذف
                      </a>
                      <a href="" class="btn btn-success" title="Show">
                        معلومات
                        </a>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="span text-center" style="margin-top: 20px; margin-bottom:10px">

            {{ $courses->links() }}

        </span>

          </div>
          <!-- /.card-body -->

        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>

@endsection

@section('scripts')

 <script>
  function performDestroy(id, reference){
    let url = '/cms/admin/courses/'+id;
    confirmDestroy(url, reference);
  }
 </script>
@endsection


