function function_alert(role) {
    var decision = confirm('Are You Sure ?');
    if (decision) {
        
        window.location.href = "./delete-role/" + role;
    }
}
//  To show Edit Modal
$(document).ready(function () {
    $('.editbtn').on('click', function (e) {
        var roleId = e.target.id;
        var aUrl = "/getEditRoleData/" + roleId;
        $.ajax({
            url: aUrl,
            type: 'get',
            success: function (data) {
                $('#editRoleModal').modal('show');
                $('#id').val(data['id']);
                $('#rolefield').val(data['name']);
                function getPermissionId(item) {
                    return item.id;
                }
                var permissions = data['permissions'].map(getPermissionId);
                $('#permissionSelect').val(permissions);
                $('#permissionSelect').trigger('change');

            }
        });

    })
});