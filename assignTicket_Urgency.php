<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php insert data in mysql by using bootstrap modal </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</head>
<style>
    body {
        background: #3f0d12;
    }
</style>

<body><br><br><br>
<div class="container">
    <div class="row">
        <div class="col-lg-4 offset-lg-4">

            <div class="card">
                <div class="card-header text-uppercase text-center"><b>Ticketing System</b></div>
                <div class="card-body">
                    <div class="col-md-12">
                        <span id="AlertMessage"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <center><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add</button></center>
                </div>

                <br>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">INSERT DATA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success d-none success"></div>
                <div class="alert alert-danger d-none error"></div>
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Staff ID</label>
                        <input type="text" class="form-control" id="staff_id" placeholder="Enter the staff Id">
                    </div>
                </form>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Select Urgency:</label>
                        <select name="priority" id="priority" class="form-control">
                            <option value="">---Set Urgency---</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submit">Insert</button>
                    </div>
                </div>
            </div>

            <script>
                $(function() {
                    $(document).on('click', '#submit', function(e) {
                        e.preventDefault();

                        var staff_id = $('#staff_id').val();
                        var priority = $('#priority').val();
                        if (priority == "Low"){
                            priority = 1
                        }
                        else if(priority == "Medium"){
                            priority = 2
                        }
                        else{
                            priority = 3
                        }

                        if (staff_id == '') {
                            alert('Please enter Staff ID')
                        } else {
                            $.ajax({
                                url: 'insert.php',
                                method: 'post',
                                data: {
                                    staff_id: staff_id,
                                    priority: priority
                                },
                                dataType: 'json',
                                success: function(data) {

                                    $("#AlertMessage").html('');
                                    $('#exampleModal').modal('hide');

                                    if(data.status==true){

                                        $("#AlertMessage").html('<p class="alert alert-success">'+data.Message+'</p>');
                                    }else{
                                        $("#AlertMessage").html('<p class="alert alert-danger">'+data.Message+'</p>');

                                    }

                                    setTimeout(() => {
                                        $("#AlertMessage").html('');
                                    }, 2000);
                                    // $('.success').removeClass('d-none').html(data);
                                },
                                error: function(data) {
                                    $("#AlertMessage").html('<p class="alert alert-danger">Fail! try again...</p>');
                                    // $('.error').removeClass('d-none').html(data);
                                }
                            });
                        }
                    });
                });


            </script>

        </div>
</body>

</html>
