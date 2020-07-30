@extends('AdminLTE.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Task</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action='addTask' enctype="multipart/form-data" method="post" class="form-horizontal">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="title" name='title' placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Details</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="description" name='description' placeholder="Description" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Start Date</label>
                                        <div class="col-sm-10">
                                            <input type="datetime-local" class="form-control" id="startDate" name='startDate'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Duration</label>
                                        <div class="col-sm-10">
                                            <div class="custom-control custom-radio">
                                                <label class='radio-inline'>
                                                    <input type='radio' id='hours' value='hours' name='durationFormat'>Hours
                                                </label>
                                                <label style="margin-left: 10px;" class='radio-inline'>
                                                    <input type='radio' id='days' value='days' name='durationFormat'>Days
                                                </label>

                                            </div>



                                            <input type='number' class='form-control' id='duration' name='duration'>

                                        </div>
                                    </div>

                                    <div class='form-group row'>
                                        <label for='assignTo' class='col-sm-2 col-form-label'>Assign To</label>
                                        <div class='col-sm-10'>
                                            <select name='assignTo' id='assignTo' class='custom-select'>

                                                @if($assignedUsers)
                                                @foreach($assignedUsers as $user)

                                                <option value='{{$user->id}}'>{{$user->name}}</option>

                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Priority</label>
                                        <div class="col-sm-10">
                                            <div class="custom-control custom-radio">
                                                <label style="margin-left: 10px;" class='radio-inline'>
                                                    <input type='radio' id='high' value='high' name='priority'>High
                                                </label>
                                                <label style="margin-left: 10px;" class='radio-inline'>
                                                    <input type='radio' id='medium' value='medium' name='priority'>Medium
                                                </label>
                                                <label style="margin-left: 10px;" class='radio-inline'>
                                                    <input type='radio' id='low' value='low' name='priority'>Low
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">ADD TASK</button>
                                </div>
                        </div>

                        </form>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection