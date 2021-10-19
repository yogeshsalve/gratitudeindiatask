<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>

</head>
  <style>
  .alert-message {
    color: red;
  }
</style>
<body>

<div class="container">
    <h2 style="margin-top: 12px;" class="alert alert-success">TASK CREATED FOR GRATITUDE INDIA -       
     </h2><br>
     <div class="row">
       <div class="col-12 text-right">
         <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-post" onclick="addPost()">Add Question</a>
       </div>
    </div>
    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12">
          <table id="laravel_crud" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Option1</th>
                    <th>Option2</th>
                    <th>Option3</th>
                    <th>Option4</th>
                    <th>Category</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                <tr id="row_{{$exam->id}}">
                   <td>{{ $exam->id  }}</td>
                   <td>{{ $exam->question }}</td>
                   <td>{{ $exam->option1 }}</td>
                   <td>{{ $exam->option2 }}</td>
                   <td>{{ $exam->option3 }}</td>
                   <td>{{ $exam->option4 }}</td>
                   <td>{{ $exam->category }}</td>
                   <td><a href="javascript:void(0)" data-id="{{ $exam->id }}" onclick="editPost(event.target)" class="btn btn-info">Edit</a></td>
                   <td>
                    <a href="javascript:void(0)" data-id="{{ $exam->id }}" class="btn btn-danger" onclick="deletePost(event.target)">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
          </table>
       </div>
    </div>
</div>



<div class="modal fade" id="post-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <form name="userForm" class="form-horizontal">
               <input type="hidden" name="post_id" id="post_id">
                <div class="form-group">
                    <label for="name" class="col-sm-2">Question</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="question" name="question" placeholder="Enter Question">
                        <span id="questionError" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Option 1</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="option1" name="option1" placeholder="Enter Option 1" rows="1" cols="50">
                        </textarea>
                        <span id="option1Error" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Option 2</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="option2" name="option2" placeholder="Enter Option 2" rows="1" cols="50">
                        </textarea>
                        <span id="option2Error" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Option 3</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="option3" name="option3" placeholder="Enter Option 3" rows="1" cols="50">
                        </textarea>
                        <span id="option3Error" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Option 4</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="option4" name="option4" placeholder="Enter Option 4" rows="1" cols="50">
                        </textarea>
                        <span id="option4Error" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Category</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="category" name="category" placeholder="Enter Category" rows="1" cols="50">
                        </textarea>
                        <span id="categoryError" class="alert-message"></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="createPost()">Save</button>
        </div>
    </div>
  </div>
</div>
</body>






<script>
  $('#laravel_crud').DataTable();

  function addPost() {
    $("#post_id").val('');
    $('#post-modal').modal('show');
  }

  function editPost(event) {
    var id  = $(event).data("id");
    let _url = `/exams/${id}`;
    $('#questionError').text('');
    $('#option1Error').text('');
    $('#option2Error').text('');
    $('#option3Error').text('');
    $('#option4Error').text('');
    $('#categoryError').text('');
    
    $.ajax({
      url: _url,
      type: "GET",
      success: function(response) {
          if(response) {
            $("#post_id").val(response.id);
            $("#question").val(response.question);
            $("#option1").val(response.option1);
            $("#option2").val(response.option2);
            $("#option3").val(response.option3);
            $("#option4").val(response.option4);
            $("#category").val(response.category);
            $('#post-modal').modal('show');
          }
      }
    });
  }

  function createPost() {
    var question = $('#question').val();
    var option1 = $('#option1').val();
    var option2 = $('#option2').val();
    var option3 = $('#option3').val();
    var option4 = $('#option4').val();
    var category = $('#category').val();
    var id = $('#post_id').val();

    let _url     = `/exams`;
    let _token   = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: _url,
        type: "POST",
        data: {
          id: id,
          question: question,
          option1: option1,
          option2: option2,
          option3: option3,
          option4: option4,
          category: category,
          _token: _token
        },
        success: function(response) {
            if(response.code == 200) {
              if(id != ""){
                $("#row_"+id+" td:nth-child(2)").html(response.data.question);
                $("#row_"+id+" td:nth-child(3)").html(response.data.option1);
                $("#row_"+id+" td:nth-child(3)").html(response.data.option2);
                $("#row_"+id+" td:nth-child(3)").html(response.data.option3);
                $("#row_"+id+" td:nth-child(3)").html(response.data.option4);
                $("#row_"+id+" td:nth-child(3)").html(response.data.category);
              } else {
                $('table tbody').prepend('<tr id="row_'+response.data.id+'"><td>'+response.data.id+'</td><td>'+response.data.question+'</td><td>'+response.data.option1+'</td> <td>'+response.data.option2+'</td><td>'+response.data.option3+'</td><td>'+response.data.option4+'</td><td>'+response.data.category+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editPost(event.target)" class="btn btn-info">Edit</a></td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deletePost(event.target)">Delete</a></td></tr>');
              }
              $('#question').val('');
              $('#option1').val('');
              $('#option2').val('');
              $('#option3').val('');
              $('#option4').val('');
              $('#category').val('');

              $('#post-modal').modal('hide');
            }
        },
        error: function(response) {
          $('#questionError').text(response.responseJSON.errors.question);
          $('#option1Error').text(response.responseJSON.errors.option1);
          $('#option2Error').text(response.responseJSON.errors.option2);
          $('#option3Error').text(response.responseJSON.errors.option3);
          $('#option4Error').text(response.responseJSON.errors.option4);
          $('#categoryError').text(response.responseJSON.errors.category);
        }
      });
  }

  function deletePost(event) {
    var id  = $(event).data("id");
    let _url = `/exams/${id}`;
    let _token   = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: _url,
        type: 'DELETE',
        data: {
          _token: _token
        },
        success: function(response) {
          $("#row_"+id).remove();
        }
      });
  }

</script>
</html>