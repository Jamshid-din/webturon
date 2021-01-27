@extends('layouts.app', ['activePage' => 'role', 'titlePage' => __('User Roles'),'show' => 'user'])

@section('content')
  <!-- Navbar -->

  <div class="content">
    @if (count($errors) > 0)
      <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      </div>
    @endif

    @if(session('success'))
      <div class="box box-default">
          <div class="box-body">
              <div class="row">
                  <div class="col-md-12">
                      <div class="alert alert-success">
                          <h4 class="modal-title"> {{ session('success') }}</h4>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    @endif

    <div class="container-fluid">
    
      <div class="row">
        <div class="col-md-12">

            <div class="card">

              <div class="card-header card-header-primary">
                <h4 class="card-title ">Roles</h4>
                <p class="card-category"> Here you can manage user roles</p>
              </div>
              
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add"><i class="fa fa-plus" ></i> Add user</a>
                  </div>
                </div>

    
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-menu">

                    <div class="table-responsive">
                      <table class="table">
                          <thead class=" text-primary">
                          <tr>
                              <th> # </th>
                              <th> Title Uz </th>
                              <th> Title Ru</th>
                              <th> Role Code</th>
                              <th> Status</th>
                              <th> Created</th>
                              <th class="text-right"> Actions </th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach($models as $key => $model)
                              <tr id="row_{{ $model->id}}">
                                <td>{{ $key+1}}</td>
                                <td>{{ $model->title_uz }}</td>
                                <td>{{ $model->title_ru }}</td>
                                <td>{{ $model->role_code }}</td>
                                <td>
                                  @if($model->status)
                                    <snap class="btn btn-success btn-link p-1" rel="tooltip">
                                      <i class="material-icons">check_circle_outline</i>
                                      <div class="ripple-container"></div>
                                    </span>
                                  @else
                                    <snap class="btn btn-danger btn-link p-1" rel="tooltip">
                                      <i class="material-icons">error_outline</i>
                                      <div class="ripple-container"></div>
                                    </span>
                                  @endif
                                </td>
                                <td>{{ $model->created_at }}</td>
                                <td class="text-right">
                                  <a rel="tooltip" class="btn btn-success btn-link m-0 p-1 editLink" href="#" data-id="{{$model->id}}"  data-toggle="modal" data-target="#edit">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                  </a>
                                  @if($model->role_code != 'super_admin')
                                  <a rel="tooltip" class="btn btn-danger btn-link m-0 p-1 deleteLink" href="#" data-id="{{$model->id}}" data-toggle="modal" data-target="#delete">
                                    <i class="material-icons">close</i>
                                    <div class="ripple-container"></div>
                                  </a>
                                  @endif
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                      {{ $models->links() }}
                    </div>

                  </div>
                  
                </div>

              </div>

            </div>
            
        </div>
      </div>
    </div>
  </div>

  <!-- Add Parent Modal -->
  <div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="card card-signup card-plain">
            <div class="modal-header">
              <h5 class="modal-title card-title">Add New Menu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="material-icons">clear</i>
              </button>
            </div>

            <div class="modal-body">
              
              <div class="row">
                <div class="col-md-10 m-auto">
                  <form class="form" method="POST" action="{{ route('user-roles.store') }}" enctype="multipart/form-data">
                    @csrf

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="storeTitle_uz" class="form-control" name="title_uz" placeholder=" Title UZ..." required>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="storeTitle_ru" class="form-control" name="title_ru" placeholder=" Title RU..." required>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="storeRole_code" class="form-control" name="role_code" placeholder=" Role code..." required>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">done_all</i></div>
                          </div>
                          <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="status" id="storeStatusActive" value="1" checked> Active
                              <span class="circle">
                                  <span class="check"></span>
                              </span>
                            </label>
                          </div>

                          <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="status" id="storeStatusPassive" value="0"> Passive
                              <span class="circle">
                                  <span class="check"></span>
                              </span>
                            </label>
                          </div>

                        </div>
                      </div>

                      <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-round">Store</button>
                      </div>

                  </form>
                </div>

              </div>
            </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Update Modal -->
  <div class="modal fade bd-example-modal-lg" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="card card-signup card-plain">
            <div class="modal-header">
              <h5 class="modal-title card-title">Update Document</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="material-icons">clear</i>
              </button>
            </div>

            <div class="modal-body">
              
              <div class="row">
                <div class="col-md-10 m-auto">
                  <form id="updateForm" class="form" method="POST" action="{{ route('user-roles.update', 0) }}" enctype="multipart/form-data">

                  {{ csrf_field() }}
                  {{ method_field('PATCH') }}
                      <input type="text" name="id" id="update_id" hidden>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="updateTitle_uz" class="form-control" name="title_uz" placeholder="Title uz..." required>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="updateTitle_ru" class="form-control" name="title_ru" placeholder="Title ru..." required>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="updateRole_code" class="form-control" name="role_code" placeholder=" Role code..." readonly>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">done_all</i></div>
                          </div>
                          <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="status" id="updateStatusActive" value="1" checked> Active
                              <span class="circle">
                                  <span class="check"></span>
                              </span>
                            </label>
                          </div>

                          <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="status" id="updateStatusPassive" value="0"> Passive
                              <span class="circle">
                                  <span class="check"></span>
                              </span>
                            </label>
                          </div>

                        </div>
                      </div>

                    <div class="modal-footer justify-content-center">
                      <button type="submit" class="btn btn-warning btn-round">Update</button>
                    </div>

                  </form>
                </div>

              </div>
            </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Remove Doc Modal -->
  <div class="modal fade bd-example-modal-simple" id="delete" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-simple" role="document">
          <div class="modal-content">
              <div class="card card-signup card-plain">

                <div class="modal-header">
                  <h5 class="modal-title card-title">Delete Document</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="material-icons">clear</i>
                  </button>
                </div>

                <div class="modal-body">
                  
                  <div class="row">
                    <div class="col-md-10 m-auto">

                        <h4 class="text-center">Are you sure you want to delete?</h4>

                        <input type="number" class="form-control" name="id" value="" hidden>

                        <div class="modal-footer justify-content-center">
                          <a type="submit" id="deleteConfirm" class="btn btn-danger btn-round text-white" data-boolval="true">Delete</a>
                        </div>

                    </div>

                  </div>
                </div>

              </div>
          </div>
      </div>
  </div>
  
  <!-- Response Modal -->
  <div id="responseModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-center">Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<!--   Core JS Files   -->
<script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
<script src="{{ asset('material') }}/js/core/main.js"></script>
<script>
  $(document).ready(function(){
    // Token
    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    $('select').selectpicker()

    $('.editLink').click(function(){
      
      let itemId = $(this).data('id')

      $.ajax({
        url: '/user-roles/' + itemId,
        data: {
          _token: csrf_token,
          id    : itemId
        },
        type: 'get',
        success: function(result){
          let model = result['model']

          // Reset form befor uploading old document info
          $("#updateForm").trigger('reset');

          // Storing old document info into Update Modal
          
          $('#update_id').val(model.id)
          $('#updateTitle_uz').val(model.title_uz)
          $('#updateTitle_ru').val(model.title_ru)
          $('#updateRole_code').val(model.role_code)

          if(model.status){
            $('#updateStatusActive').prop('checked',true)
          }
          else{
            $('#updateStatusPassive').prop('checked', true)
          } 
          
        },
        error: function(error){
          console.log(error)
        }
      })

    })

    // Delete list item
    $(".deleteLink").click( function () {
      let itemId = $(this).data('id')
      $("#deleteConfirm").unbind().click(function() {

        $.ajax({
          url: '/user-roles/' + itemId,
          data: {
            _token: csrf_token,
            id    : itemId
          },
          type: 'delete',
          
          success: function(result) {

            let error = result['error']

            if(error){
              $('#delete').modal('toggle')
              $('#responseModal .modal-title').text('Warning')
              $('#responseModal .modal-footer button').removeClass('btn-danger btn-success').addClass('btn-danger')
              $('#responseModal').modal('toggle')
              $('#responseModal .modal-body p').text(result.error)
              setTimeout(function() {$('#responseModal').modal('hide')}, 2500)
            }
            else{
              $('#delete').modal('toggle')
              $('#responseModal .modal-title').text('Success')
              $('#responseModal .modal-footer button').removeClass('btn-danger').addClass('btn-success')
              $('#responseModal').modal('toggle')
              $('#responseModal .modal-body p').text(result)
              setTimeout(function() {$('#responseModal').modal('hide')}, 1500)
              $('#row_'+itemId).remove()
            }


            
          },
          error: function(){
            $('#delete').modal('toggle')
            $('#responseModal .modal-title').text('Error')

            $('#responseModal .modal-footer button').removeClass('btn-success').addClass('btn-danger')
            $('#responseModal').modal('toggle')
            $('#responseModal .modal-body p').text('The record failed on delete!')

            setTimeout(function() {$('#responseModal').modal('hide')}, 1500)
          }
        })
      })
    }) 
    

  })
  // End of Ready Function





  // Clear Saerch Filter
  $('#clearSearchForm').click(function(){
    $("#searchTitle_uz").val('');
    $("#searchTitle_ru").val('');
    $("#searchStatusActive").prop('checked', false);
    $("#searchStatusPassive").prop('checked', false);
    $('#parentMenu').selectpicker('val', '');
  })
</script>


@endsection
