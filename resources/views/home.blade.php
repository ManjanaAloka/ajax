<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel AJAX</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-sweetalert@1.0.1/dist/sweetalert.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- add new student -->
    <div class="modal fade" id="create_student" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="#" id="add_student_form" enctype="multipart/form-data">
                <div class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Student</h5>
                        <button type="button" class="close" id="student_form_close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <p class="form-text">
                                        Name field is required
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="avatar" name="avatar" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="add_student_btn" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="edit_student" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="#" id="edit_student_form" enctype="multipart/form-data">
                <div class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Student</h5>
                        <button type="button" class="close" id="student_form_close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            @csrf
                            <input type="hidden" name="std_id" value="" id="std_id" readonly>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="edit_name" name="name"
                                        value="" required>
                                    <p class="form-text">
                                        Name field is required
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" id="edit_email"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_avatar" class="col-sm-2 col-form-label">Avatar</label>
                                <div class="col-sm-10" id="edit_avatar">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="edit_student_btn" class="btn btn-primary">Update Student</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal end -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4 shadow">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between">
                            <h5>Student Management System</h5>
                            <button type="button" class="btn gray btn-md" data-toggle="modal"
                                data-target="#create_student">
                                Add Student <i class="bi bi-plus-square-dotted"></i>
                            </button>
                        </div>
                        <table id="myTable" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="std_tb_body">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-sweetalert@1.0.1/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            // ================Fetch All Student===============
            fetchAllStudents();

            function fetchAllStudents() {
                $.ajax({
                    url: '{{ route('showData') }}',
                    method: 'get',
                    success: function(response) {
                        $("#std_tb_body").html(response);
                        $('#myTable').DataTable();
                    }
                });
            }

            // ================EditView Student===============

            $(document).on("click", '.edit_student', function(e) {
                e.preventDefault();
                var stID = $(this).attr("id");
                $.post('{{ route('findData') }}', {
                        'id': stID,
                        '_token': '{{ csrf_token() }}'
                    },
                    function(data) {
                        $("#edit_student_btn").text("Update Student");
                        $("#edit_name").val(data.name);
                        $("#edit_email").val(data.email);
                        $("#std_id").val(data.id);
                        $("#edit_avatar").html(`
                            <input type="file" name="edit_avatar" id="edit_std_avatar" hidden>
                            <label for="edit_std_avatar" class="rounded-circle" style="overflow:hidden;"><img src="storage/images/${data.avatar}" alt="asd" style="width: 150px;height: 150px;"></label>
                        `);
                    }
                );

            });

            // ================Add Student===============

            $("#add_student_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $.ajax({
                    url: '{{ route('saveStudent') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        $("#add_student_btn").text("Adding...");
                        // console.log(response);
                        alert(response['std_name'] + " added Success.");
                        setInterval(function() {
                            $("#student_form_close").click();
                            fetchAllStudents();
                        }, 500);
                    }
                });
            });

            // ================Update Student===============

            $("#edit_student_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $.ajax({
                    url: '{{ route('updateData') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        $("#edit_student_btn").text("Updating...");
                        swal("Updated !", "Student Update Successfull..!", "success");

                        setInterval(function() {
                            $('#edit_student_form')[0].reset();
                            $('#edit_student').modal('hide');
                            fetchAllStudents();
                        }, 500);
                    }
                });
            });


        });
    </script>

</body>

</html>
