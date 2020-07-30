@extends('AdminLTE.layout');
@section ('content')
<div class="content-wrapper">
  <div class='container-fluid'>
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              Edit Task
            </h3>

          </div><!-- /.card-header -->
          <div class="row">
            <section class="col-lg-8 connectedSortable">
              <div class="card1">

                <form action='editTaskAction' . enctype="multipart/form-data" method="post" class="form-horizontal">
                  @csrf
                  <input type="hidden" name="id" value='{{$task->id}}'>

                  <div class="card-body">

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Title</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name='title' value="{{$task->title}}" placeholder="Title">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Description</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" id="description" name='description' placeholder="Description" cols="30" rows="2">{{$task->description}}</textarea>

                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Start Date</label>
                      <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" id="startDate" name='startDate' value="{{$task->startDate}}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">End Date</label>
                      <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" id="endDate" name='endDate' value="{{$task->endDate}}">
                      </div>
                    </div>


                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Duration</label>
                      <div class="col-sm-10">
                        <div class="custom-control custom-radio">
                          <?php
                          if ($task->durationUnit == 'hours') {
                            echo "<label class='radio-inline'>
                            <input type='radio' id='hours' value='hours' name='durationFormat' checked>Hours
                          </label>";
                          } else {
                            echo "<label class='radio-inline'>
                            <input type='radio' id='hours' value='hours' name='durationFormat' >Hours
                          </label>";
                          }

                          if ($task->durationUnit == 'days') {
                            echo "<label style='margin-left: 10px;' class='radio-inline'>
                            <input type='radio' id='days' value='days' name='durationFormat' checked>Days
                          </label>";
                          } else {
                            echo "<label style='margin-left: 10px;' class='radio-inline'>
                            <input type='radio' id='days' value='days' name='durationFormat' >Days
                          </label>";
                          }

                          ?>
                        </div>
                        <input type='number' class='form-control' id='duration' value="{{$task->duration}}" name='duration'>

                      </div>
                    </div>







                    <?php
                    $designation = session()->get('designation');

                    ?>
                    @if($designation == 'lead')
                    <div class='form-group row'>
                      <label for='assignTo' class='col-sm-2 col-form-label'>Assign To</label>
                      <div class='col-sm-10'>
                        <select name='assignTo' id='assignTo' class='custom-select'>
                          @if($assignedUsers)
                          @foreach($assignedUsers as $user)
                          <?php
                          if ($task->assignedUserId == $user->id) {
                            # code...
                            echo "<option value='{$user->id}' selected>{$user->name}</option>";
                          } else {
                            # code...
                            echo "<option value='{$user->id}'>{$user->name}</option>";
                          }

                          ?>
                          @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    @endif





                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Priority</label>
                      <div class="col-sm-10">
                        <div class="custom-control custom-radio">
                          <?php
                          if ($task->priority == 'high') {
                            echo " <label style='margin-left: 10px;'  class='radio-inline'>
                            <input type='radio' id='high' value='high' name='priority' checked>High
                          </label>";
                          } else {
                            echo " <label  style='margin-left: 10px;' class='radio-inline'>
                            <input type='radio' id='high' value='high' name='priority' >High
                          </label>";
                          }
                          if ($task->priority == 'medium') {
                            echo "<label  style='margin-left: 10px;' class='radio-inline'>
                            <input type='radio' id='medium' value='medium' name='priority' checked>Medium
                          </label>";
                          } else {
                            echo "<label  style='margin-left: 10px;' class='radio-inline'>
                            <input type='radio' id='medium' value='medium' name='priority' >Medium
                          </label>";
                          }
                          if ($task->priority == 'low') {
                            echo "<label  style='margin-left: 10px;' class='radio-inline'>
                            <input type='radio' id='low' value='low' name='priority' checked>Low
                          </label>";
                          } else {
                            echo "<label  style='margin-left: 10px;' class='radio-inline'>
                            <input type='radio' id='low' value='low' name='priority' >Low
                          </label>";
                          }
                          ?>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <button type="submit" class="btn btn-primary float-right">Save changes</button>

                    </div>

                  </div>
                </form>

              </div>
            </section>

            <section class="col-lg-4 connectedSortable">
              <div style="margin-top: 18px;" class="card1">

                <form id='statusForm' enctype="multipart/form-data" action="editTaskStatus" method="post">
                  @csrf

                  <input type="hidden" name='taskId' value='{{$task->id}}'>
                  <div class='form-group row'>
                    <div class='col-sm-10'>
                      <select name='selectStatus' id='selectStatus' class='custom-select'>
                        <option value="">Choose:</option>

                        @if($status)
                        @foreach($status as $s)
                        <?php
                        if ($task->statusId == $s->id) {
                          echo "<option value='{$s->id}' selected>{$s->status}</option>";
                        } else {
                          echo "<option value='{$s->id}'>{$s->status}</option>";
                        }

                        ?>


                        @endforeach
                        @endif
                      </select>
                    </div>
                  </div>


                </form>

              </div>
            </section>


          </div>









        </div>

        <!-- /.card -->

        <!-- DIRECT CHAT -->
        <div class="card direct-chat direct-chat-primary">
          <div class="card-header">
            <h3 class="card-title">Ask Queries</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>

              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- Conversations are loaded here -->
            <div id='commentDiv' class="direct-chat-messages">


            </div>
            <!--/.direct-chat-messages-->


          </div>
          <!-- /.card-body -->
          <div class="card-footer">



            <form action="/askQuery/{{$task->id}}" method="get">
              <div class='queryContainer'>
                <div>
                  <input type='hidden' id='taskTitle' name='taskTitle' value="{{$task->title}}" />
                  <input type='hidden' id='toId' name='toId' />
                  <input type="text" id='query' name="query" placeholder="Type Message ..." autocomplete="off" class="form-control" onInput='check()'>
                  <div class='suggestion' id='suggestion'></div>
                </div>








              </div>
              <button type="submit" class="btn btn-primary">Send</button>

            </form>


            <!-- /.card-footer-->
          </div>
          <!--/.direct-chat -->

      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->

      <!-- right col -->

    </div>
  </div>

</div>
<script>
  var selectStatus = document.getElementById('selectStatus');
  selectStatus.onchange = function() {
    var statusForm = document.getElementById('statusForm')
    statusForm.submit()

  }

  var inputQuery = document.getElementById('query');
  var suggestionPanel = document.getElementById('suggestion');
  var users = <?php echo json_encode($users); ?>;

  function check(e) {
    var query = inputQuery.value
    suggestionPanel.innerHTML = ""
    if (query.endsWith('@')) {
      users.forEach(user => {

        const div = document.createElement('div');
        div.setAttribute("id", 'divName');
        div.className = user['id']
        div.innerHTML = user['name'];
        suggestionPanel.appendChild(div);
      });
    }
  }
  var toIDArray = [];

  suggestionPanel.addEventListener('click', (e) => {
    var container = document.querySelector('.queryContainer');
    var toIdField = document.getElementById('toId');

    var user = users.find(element => element.id == e.target.classList[0])

    var Email = user.email
    var id = e.target.classList[0]
    toIDArray.push(id);
    console.log(toIDArray)
    inputQuery.value += user.name
    toIdField.value = toIDArray;



  });
</script>

<script>
  var queries = <?php echo json_encode($queries); ?>;
  var currentUser = <?php echo session()->get('id'); ?>;
  var comments = document.getElementById('commentDiv');
  queries.forEach(previousComment => {
    console.log(previousComment['fromUid']);
    if (previousComment['fromUid'] != currentUser) {
      console.log('current')
      comments.insertAdjacentHTML('afterbegin', `<div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">` + previousComment.name + `</span>
                      <span class="direct-chat-timestamp float-right">` + previousComment.created_at + `</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="/dist/img/user1-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                    ` + previousComment.query + `
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>`)



    } else {
      console.log('not current')

      comments.insertAdjacentHTML('afterbegin', `<div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">` + previousComment.name + `</span>
                      <span class="direct-chat-timestamp float-left">` + previousComment.created_at + `</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="/dist/img/user3-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                    ` + previousComment.query + `
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>`)
    }


  });
</script>
@endsection