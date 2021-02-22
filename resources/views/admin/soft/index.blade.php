@extends('layouts.app', ['activePage' => 'software', 'titlePage' => __('Software'), 'show' => 'soft'])

@section('content')
  <!-- Navbar -->
  <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>

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
              <h4 class="card-title ">Software</h4>
              <p class="card-category"> <!-- Here you can manage archive docuements --></p>
            </div>
            <div class="card-body">
              
              <div class="d-flex justify-content-between">
                <div class="col-3">
                  <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add </a>
                </div>
                <div class="col-3 text-right">
                  <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#search"><i class="fa fa-search"></i> Search </a>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                      <th> # </th>
                      <th> Menu </th>
                      <th> Name</th>
                      <th> Size</th>
                      <th> Status</th>
                      <th> Created at</th>
                      <th class="text-right"> Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($models as $key => $model)
                      <tr id="row_{{ $model->id }}">
                        <td>{{ $key+1}}</td>
                        <td>{{ $model->softmenu->title_uz??'' }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->size }}</td>
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
                        <td class="td-actions text-right">
                          <a rel="tooltip" class="btn btn-success btn-link m-0 p-1 editLink" href="#" data-id="{{$model->id}}"  data-toggle="modal" data-target="#edit">
                            <i class="material-icons">edit</i>
                            <div class="ripple-container"></div>
                          </a>
                          <a rel="tooltip" class="btn btn-danger btn-link m-0 p-1 deleteLink" href="#" data-id="{{$model->id}}" data-toggle="modal" data-target="#delete">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                          </a>
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

  <!-- Add Doc Modal -->
  <div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="card card-signup card-plain">
          <div class="modal-header">
            <h5 class="modal-title card-title">Add New Document</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="material-icons">clear</i>
            </button>
          </div>

          <div class="modal-body">
            
            <div class="row">
              <div class="col-md-10 m-auto">
                <form class="form" method="POST" action="{{ route('admin-soft.store') }}" enctype="multipart/form-data">
                  @csrf

                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">menu</i></div>
                      </div>
                      <select class="form-control" data-style="btn btn-link" id="selectMenu" name="menu_id" virtualScroll="true" data-live-search="true" required>
                        <option value="" disabled selected>Select Parent Menu</option>
                        @foreach($menu_list as $value)
                          <option value="{{ $value->id }}"> {{ $value->title_uz}} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="form-group form-file-upload form-file-simple">
                    <div class="input-group">
                      <div class="input-group-text"><i class="material-icons">cloud_upload</i></div>
                      <input type="text" name="filename" class="form-control inputFileVisible" placeholder="Upload File ..." required>
                      <input type="file" name="file" class="inputFileHidden" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">done_all</i></div>
                      </div>
                      <div class="form-check form-check-radio form-check-inline">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="status" id="radioActive" value="1" checked> Active
                          <span class="circle">
                              <span class="check"></span>
                          </span>
                        </label>
                      </div>

                      <div class="form-check form-check-radio form-check-inline">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="status" id="radioPassive" value="0"> Passive
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

  <!-- Search Doc Modal -->
  <div class="modal fade bd-example-modal-lg" id="search" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="card card-signup card-plain">
                
                <div class="modal-header">
                  <h5 class="modal-title card-title">Searching ...</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="material-icons">clear</i>
                  </button>
                </div>

                <div class="modal-body">
                  
                  <div class="row">
                    <div class="col-md-10 m-auto">
                      <form id="searchForm" class="form" method="POST" action="{{ route('admin-soft.search') }}">
                        @csrf

                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="material-icons">menu</i></div>
                            </div>
                            <select class="form-control" data-style="btn btn-link" id="searchMenu" name="menu_id" virtualScroll="true" data-live-search="true">
                              <option value="" disabled selected>Select Parent Menu</option>
                              @foreach($menu_list as $value)
                                @if($value->id == ($menu_id??''))
                                  <option value="{{ $value->id }}" selected> {{ $value->title_uz }} </option>
                                @else
                                  <option value="{{ $value->id }}"> {{ $value->title_uz }} </option>
                                @endif
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="material-icons">title</i></div>
                            </div>
                              <input type="text" id="searchTitle" class="form-control" name="title" placeholder="Document Title..." value="{{ $title??'' }}">
                          </div>
                        </div>


                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="material-icons">done_all</i></div>
                            </div>
                            <div class="form-check form-check-radio form-check-inline">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="status" id="searchStatusActive" value="1" {{ ($status??'') ? 'checked':'' }}> Active
                                <span class="circle">
                                    <span class="check"></span>
                                </span>
                              </label>
                            </div>

                            <div class="form-check form-check-radio form-check-inline">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="status" id="searchStatusPassive" value="0" {{ (($status??'1') == 0) ? 'checked':'' }}> Passive
                                <span class="circle">
                                    <span class="check"></span>
                                </span>
                              </label>
                            </div>

                          </div>
                        </div>

                        <div class="modal-footer justify-content-center">
                          <button type="submit" class="btn btn-primary btn-round">Search</button>
                          <a id="clearSearchForm" class="btn btn-default btn-round text-white" >Clear</a>
                          
                        </div>

                      </form>
                    </div>

                  </div>
                </div>

              </div>
          </div>
      </div>
  </div>

  <!-- Update Doc Modal -->
  <div class="modal fade bd-example-modal-lg overflow-auto" id="edit" tabindex="-1" role="dialog">
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
                <form class="form" id="updateForm"  method="POST" action="{{ route('admin-soft.update',0) }}" enctype="multipart/form-data">
                  @csrf
                  {{ method_field('PATCH') }}

                    <input type="text" name="id" id="soft_id" hidden>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">menu</i></div>
                        </div>
                        <select class="form-control" data-style="btn btn-link" id="updateMenu" name="menu_id" data-live-search="true" required>
                          <option id="defaultMenu" value="" disabled selected>Select Parent Menu</option>
                          @foreach($menu_list as $value)
                            @if($value->id == ($menu_id??''))
                              <option value="{{ $value->id }}" selected> {{ $value->title_uz }} </option>
                            @else
                              <option value="{{ $value->id }}"> {{ $value->title_uz }} </option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group form-file-upload form-file-simple">
                      <div class="input-group">
                        <div class="input-group-text"><i class="material-icons">cloud_upload</i></div>
                        <input id="updateFilename" type="text" name="filename" class="form-control inputFileVisible" placeholder="Upload File ...">
                        <input type="file" name="file" class="inputFileHidden">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="input-group">

                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">done_all</i></div>
                        </div>

                        <div class="form-check form-check-radio form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="status" id="updateStatusActive" value="1"> Active
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



  <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
  <script src="{{ asset('material') }}/js/core/main.js"></script>


<script>
  $( document ).ready(function() {
    // Token
    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    $('select').selectpicker()

    // Delete list item
    $(".deleteLink").click( function () {
      let itemId = $(this).data('id')

      $("#deleteConfirm").unbind().click(function() {

        $.ajax({
          url: '/admin-soft/' + itemId,
          data: {
            _token : csrf_token,
            id     : itemId
          },
          type: 'delete',

          success: function(result) {
            $('#delete').modal('toggle')
            $('#responseModal .modal-title').text('Success')
            $('#responseModal .modal-footer button').removeClass('btn-danger').addClass('btn-success')
            $('#responseModal').modal('toggle')
            $('#responseModal .modal-body p').text(result)

            setTimeout(function() {$('#responseModal').modal('hide')}, 1500)
            $('#row_'+itemId).remove()
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

    $('.editLink').click(function(){

      let itemId = $(this).data('id')

      $.ajax({
        url: '/admin-soft/' + itemId,
        data: {
          _token: csrf_token,
          id    : itemId
        },
        type: 'get',
        success: function(result){

          let model = result['model']
          let menu = result['menu']

          // Reset form befor uploading old document info
          $("#updateForm").trigger('reset');

          // Storing old document info into Update Modal
          
          $('#soft_id').val(model.id)
          $('#updateFilename').val(model.name)
          $('#updateMenu').selectpicker('val', menu.id);

          (model.status) ? $('#updateStatusActive').prop('checked',true) :$('#updateStatusPassive').prop('checked', true)
        },
        error: function(error){
          console.log(error)
        }
      })
    })

  })
  // End of Ready Function

  // Clear Saerch Filter
  $('#clearSearchForm').click(function(){
    $('#searchMenu').selectpicker('val', '')
    $("#searchTitle").val('')
    $("#searchStatusActive").prop('checked', false)
    $("#searchStatusPassive").prop('checked', false)
  })

</script>
@endsection

