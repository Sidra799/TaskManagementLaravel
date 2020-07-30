//  To show Edit Modal
$(document).ready(function() {
  $('.editbtn').on('click', function(e) {
    $('#edit_user').modal('show');
    var userId = e.target.id;
    // console.log(userId)

    $tr = $(this).closest('tr');
    //Set Values in Edit Modal
    var data = $tr.children('td').map(function() {
      return $(this).text();
    }).get();
    // console.log("data");
    // console.log(data);

    var name = data[1];
    var email = data[2];
    var gender = data[3];
    var designation = data[4];

    if (designation) {
      var designationId = '#' + designation;
      $(designationId).prop("checked", true);
    } else {
      $('#lead').prop("checked", false);
      $('#developer').prop("checked", false);


    }
    $('#inputId').val(userId);
    $('#inputName').val(data[1]);
    $('#inputEmail').val(data[2]);
    var genderId = '#' + gender;
    $(genderId).prop("checked", true);

  })
});

function check() {
  var currentIdfield = document.getElementById('inputId');
  var currentId = currentIdfield.value;
  console.log()
  if (document.getElementById('lead').checked == true) { 
    document.getElementById('parent').innerHTML = ''
  }
  if (document.getElementById('developer').checked == true) {
    document.getElementById('parent').innerHTML = '';
    document.getElementById('parent').insertAdjacentHTML("beforeend", " <div class='form-group row'> <label for='assignTo' class='col-sm-2 col-form-label'>Assign To</label> <div class='col-sm-10' > <select id='assignTo' name='assignTo' class='custom-select'> <option disabled>Choose Lead:</option> @if($users)  @foreach($users as $user)   @if($user->designation == 'lead' ) <option value='{{$user->id}}'>{{$user->name}}</option> @endif @endforeach @endif </select></div></div>");
  }
}