function function_alert(permission) {
    var decision = confirm('Are You Sure ?');
    if(decision){
        console.log(permission)
        window.location.href = "./delete-permission/"+permission;
    } 
}
//  To show Edit Modal
$(document).ready(function(){    
$('.editbtn').on('click',function(e){
$('#editPermissionModal').modal('show');
var permissionId= e.target.id;

$tr=$(this).closest('tr');
//Set Values in Edit Modal
var data = $tr.children('td').map(function(){
return $(this).text();
}).get();
var permission = data[1];
console.log(permission);

$('#id').val(permissionId);
$('#permissionfield').val(permission);
})
});