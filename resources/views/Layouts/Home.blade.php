@extends('AdminLTE.layout');

@section ('content')
<div class="content-wrapper">
  <div class='container-fluid'>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <form id='filterForm' method="POST" role="form" onsubmit="return false;" novalidate="novalidate" enctype="multipart/form-data">
              @csrf

              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h4>Search By Title</h4>
                  <input type="text" class="form-control" id="title" name='title' placeholder="Title">

                </div>

              </div>
          </div>

          <div class="col-lg-3 col-6">

            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>Search By Date</h4>
                <input type="datetime-local" class="form-control" id="date" name='date'>
              </div>

            </div>
          </div>

          <div class="col-lg-3 col-6">

            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h4>Search By Priority</h4>
                <select name="filterPriority" id="Priority" class='custom-select'>
                  <option value=''>Select</option>
                  <option value="high">High</option>
                  <option value="medium">Medium</option>
                  <option value="low">Low</option>
                </select>
              </div>

            </div>
          </div>

          @if($data->parent === 0)
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h4>Search By Assign To</h4>
                <select name='assignTo' id='assignTo' class='custom-select'>
                  <option value=''>Select</option>

                  @if($assignedUsers)
                  @foreach($assignedUsers as $user)

                  <option value='{{$user->id}}'>{{$user->name}}</option>

                  @endforeach
                  @endif
                </select>
              </div>

            </div>
          </div>
          @endif
        </div>
        <button type="submit" class="btn btn-info float-right">Filter Task</button>

        </form>
      </div>
    </section>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tasks</h1>
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
                @if(Session::has('error'))
                <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif
                <button type="button" class="btn btn-info float-right"><i class="fas fa-plus"></i> <a href="/addTask" style="color: white;">Add Task</a></button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead id="tableHead">
                  </thead>
                  <tbody id="tableBody">
                    <div class='pageList'></div>
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

  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-body">
          <label>Are you sure you want to delete?? </label>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger btn-sm btn-ok">Delete</a>
        </div>
      </div>
    </div>
  </div>


</div>

<!-- model -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

<script src="{{ URL::asset('js/home.js') }}"></script>
<script>
  $(document).ready(function() {
    var aUrl = "/filterTaskAction?" + $('form#filterForm').serialize();
    $.ajax({
      url: aUrl,
      type: 'post',
      success: function(data) {
        populateTable(data);
      }
    });
    $("#filterForm").validate({
      submitHandler: function(form) {
        $('input[type="submit"]').prop('disabled', true);
        var aUrl = "/filterTaskAction?" + $('form#filterForm').serialize();
        console.log(aUrl);
        $.ajax({
          type: 'post',
          url: aUrl,
          success: function(data) {
            console.log(data);
            populateTable(data);
          }
        });
        return false;
      }
    });
  });

  var populateTable = (data) => {
    var tableBody = document.getElementById('tableBody');
    var tableHead = document.getElementById('tableHead');
    var heading = "<tr>";
    data['tableHeading'].forEach(head => {
      heading += "<th>" + head + "</th>";
    });
    heading += "</tr>";
    tableHead.insertAdjacentHTML("beforeend", heading);

    var pageList = document.querySelector('.pageList');
    var tasks = data['tasks'];
    tableBody.innerHTML = '';
    pageList.innerHTML = '';
    var i = 0;
    console.log(data['tableHeading']);
    console.log(data['total'])
    var numOfPages = Math.round(data['total'] / data['taskPagination'])
    tasks.forEach(task => {
      i += 1;
      console.log(task)
      tableBody.insertAdjacentHTML("beforeend", "<tr><td>" + i + "</td><td>" + task['title'] + "</td><td>" + task['priority'] + "</td> <td>" + task['description'] + "</td><td>" + task['name'] + "</td> <td>" + task['startDate'] + "</td> <td>" + task['endDate'] + "</td> <td>" + task['duration'] + " " + task['durationUnit'] + "</td> <td>" + task['status'] + "</td> <td><button type='button' id='" + task['id'] + "' class='btn btn-primary editbtn'><a href='/editTask/" + task['id'] + "' style=color:white>Edit</a></button>  <button type='button' id='" + task['id'] + "' class='btn btn-primary deletebtn'   data-href='./delete-task/" + task['id'] + "' data-toggle='modal' data-target='#confirm-delete' >Delete</button> </td></tr>");
    });
    var test = "<div class='col-sm-12 col-md-7'>" +
      "<div class='dataTables_paginate paging_simple_numbers' id='example2_paginate'>" +
      "<ul class='pagination'>"
    if (data['prePage']) {
      test += "<li class='paginate_button page-item previous' ><a id=" + data['prePage'] + "  aria-controls='example2' data-dt-idx='0' tabindex='0' class='page-link'>Previous</a></li>";
    } else {
      test += "<li class='paginate_button page-item previous disabled' ><a  " +
        "aria-controls='example2' data-dt-idx='0' tabindex='0' class='page-link'>Previous</a></li>";
    }
    for (let index = 1; index <= numOfPages; index++) {
      if (index == data['currentPage']) {
        test += "<li class='paginate_button page-item active'><a id=" + index + " aria-controls='example2' data-dt-idx='1' tabindex='0' class='page-link'>" + index + "</a></li>"
      } else {
        test += "<li class='paginate_button page-item '><a id=" + index + " aria-controls='example2' data-dt-idx='1' tabindex='0' class='page-link'>" + index + "</a></li>"
      }
    }
    if (data['nextPage']) {
      test += "<li class='paginate_button page-item next's><a id=" + data['nextPage'] + " aria-controls='example2' data-dt-idx='2' tabindex='0' class='page-link'>Next</a></li></ul></div></div>"

    } else {
      test += "<li class='paginate_button page-item next disabled'><a aria-controls='example2' data-dt-idx='2' tabindex='0' class='page-link'>Next</a></li></ul></div></div>"

    }
    pageList.insertAdjacentHTML("beforeend", test);
  }
  $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
  $(".pageList").click(function(e) {
    e.preventDefault();
    var pageno = e.target.id
    if (pageno) {
      var aUrl = "/filterTaskAction?page=" + pageno + " &" + $('form#filterForm').serialize();
      console.log(aUrl);
      $.ajax({
        url: aUrl,
        type: 'post',
        success: function(data) {
          populateTable(data);
        }
      });

    }
  });
</script>
@endsection