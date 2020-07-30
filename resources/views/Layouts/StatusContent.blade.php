@extends('AdminLTE.layout');

@section ('content')
<div class="content-wrapper">
<div class='container-fluid'>
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1>Status</h1>
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
              <div class="card-header">
              <button type="button"  data-toggle="modal" data-target="#addTaskModal" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add Status</button>

                
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>SNO</th>
                    <th>Status</th>
                    <th>Edit</th>

                  </tr>
                  </thead>

                  
                  <?php  $i=0; ?>
                  <tbody>
                     @foreach($status as $task)
                    <tr>
                    <td><?php $i+=1;
                    echo $i;
                    ?></td>
                    <td>{{$task->status}}</td>
                    
                    <td><button type="button" id='{{$task->id}}' class='btn btn-primary editbtn' >Edit</button>
                     
                    <button type="button" id='{{$task->id}}' class='btn btn-primary deletebtn' onclick='function_alert("{{$task->id}}")'>Delete</button>
                     
                       
                    </td>

                  </tr>
                    @endforeach 
                  
                  <tbody>

                  
                  
                </tfoot>
              </table>
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

  <div class="modal fade" id="addTaskModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Status</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action='addStatus' enctype="multipart/form-data" method="post" class="form-horizontal">
            @csrf
         <div class="card-body">
              
              <div class="form-group row">
                <label  class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="status" name='status' placeholder="Status">
                </div>
              </div>
              
             
            </div>
          </div>
         <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  <div class="modal fade" id="editStatusModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Status</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action='updateStatus' enctype="multipart/form-data" method="post" class="form-horizontal">
            @csrf
         <div class="card-body">
              <input type="hidden" id='id' name='id'>
              <div class="form-group row">
                <label  class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="statusfield" name='status' placeholder="Status">
                </div>
              </div>
              
             
            </div>
          </div>
         <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
        
    
  </div> 
  
  <!-- model -->
  <script src="{{ URL::asset('js/status.js') }}"></script>


 
@endsection
