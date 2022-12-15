{{-- @extends('dashboard.parent') --}}
@extends('dashboard.parent')

@section('title',' الزائرين ')

@section('sub-title',' تعديل الزائرين  ')

@section('active title',' تعديل بيانات الزائرين ')

@section('styles')

@endsection

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">تعديل بيانات الطلاب </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="create_form">
                        @csrf
                        <div class="card-body">

                            <br>
                            <div class="row">


                                <div class="form-group col-md-6">
                                    <label for="vistor_name">الاسم الزائر</label>
                                    <input type="text" name="vistor_name" class="form-control" id="vistor_name"
                                        placeholder="أدخل اسم الزائر" value="{{ $vistors->vistor_name }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mobile"> رقم الجوال </label>
                                    <input type="text" name="mobile" class="form-control"
                                        id="mobile" placeholder="ادخل رقم الجوال  " value="{{ $vistors->mobile }}">
                                </div>


                            </div>
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="date"> الوقت </label>
                                    <input type="date" name="date" class="form-control"
                                        id="date" placeholder="ادخل الوقت" value="{{ $vistors->date }}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="status">الحالة </label>
                                        <select class="form-control" name="status"
                                            id="status" >
                                            <option value="import">يستورد </option>
                                            <option value="export"> يصدّر </option>
                                        </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="location">الموقع  </label>
                                        <select class="form-control" name="location"
                                            id="location" >
                                            <option value="internal">داخلي  </option>
                                            <option value="external"> خارجي </option>
                                        </select>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="replay"> الردود  </label>
                                    <input type="text" name="replay" class="form-control"
                                        id="replay" placeholder=" الرد   " value="{{ $vistors->replay }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="replay_date"> وقت الرد  </label>
                                    <input type="date" name="replay_date" class="form-control"
                                        id="replay_date" placeholder=" وقت الرد    " value="{{ $vistors->replay_date }}">
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description"> الوصف</label>
                                        <textarea class="form-control" style="resize: none;" id="description"
                                            name="description" rows="4" placeholder="ادخل الوصف" cols="50"></textarea>
                                    </div>
                                </div>

                                {{-- <div class="form-group col-md-4">
                                    <label for="recepion_id"> موظف </label>
                                    <select class="form-control" name="recepion_id"
                                    id="recepion_id" >
                                    @foreach ($recepions as $recepion)

                                    <option value="{{ $recepion->id }}"> لا </option>
                                    @endforeach
                                    </select>
                                </div> --}}
                            </div>

                        </div>

                        <br>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" onclick="update({{$vistors->id}})" class="btn btn-lg btn-success">تعديل</button>
                            <a href="{{route('vistors.index')}}"><button type="button" class="btn btn-lg btn-primary">
                                    قائمة الطلاب  </button></a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

</section>
<!-- /.content -->

@endsection
<script src="{{ asset('cms/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

@section('scripts')


<script>

$('.city_id').select2({
      theme: 'bootstrap4'
    })


    function update(id){

        let formData = new FormData();
        formData.append('vistor_name',document.getElementById('vistor_name').value);
            formData.append('mobile',document.getElementById('mobile').value);
            formData.append('date',document.getElementById('date').value);
            formData.append('status',document.getElementById('status').value);
            formData.append('location',document.getElementById('location').value);
            formData.append('replay',document.getElementById('replay').value);
            formData.append('replay_date',document.getElementById('replay_date').value);
            formData.append('description',document.getElementById('description').value);
            // formData.append('recepion_id',document.getElementById('recepion_id').value);


            storeRoute('/cms/admin/update_vistors/'+id , formData );

    }

</script>


@endsection
