function function_alert(taskId) {
    var decision = confirm('Are You Sure you want to delete ?');
    if (decision) {
      console.log(taskId)
      window.location.href = "./delete-task/" + taskId;
    }
  }

  