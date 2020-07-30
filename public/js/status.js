function function_alert(statusId) {
    var decision = confirm('Are You Sure ?');
    if(decision){
        console.log(statusId)
        window.location.href = "./delete-status/"+statusId;
    }
}
//  To show Edit Modal
$(document).ready(function(){    
$('.editbtn').on('click',function(e){
$('#editStatusModal').modal('show');
var statusId= e.target.id;

$tr=$(this).closest('tr');
//Set Values in Edit Modal
var data = $tr.children('td').map(function(){
return $(this).text();
}).get();
var status = data[1];
console.log(status);

$('#id').val(statusId);
$('#statusfield').val(status);
})
});