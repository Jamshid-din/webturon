@extends('layouts.app', ['activePage' => 'dep-menu', 'titlePage' => __('Department Menu'),'show' => 'menu'])

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
                <ul class="nav nav-tabs" id="pills-tab">             
                    <li class="nav-item">
                        <a class="nav-link text-white" id="pills-menu-tab" href="{{ route('admin-menu-dep') }}">Parent Menu </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white active" id="pills-submenu-tab" href="{{ route('admin-menu-dep-sub') }}">Sub Menu</a>
                    </li>
                </ul>                
                <p class="card-category"> <!-- Here you can manage sub departments --></p>
              </div>
              
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div class="col-3">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i>  Add </a>
                  </div>
                  <div class="col-3 text-right">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#search"><i class="fa fa-search"></i> Search </a>
                  </div>
                </div>

    
                <div class="tab-content" id="pills-tabContent">
                  <div class="" id="pills-menu">

                    <div class="table-responsive">
                      <table class="table">
                          <thead class=" text-primary">
                          <tr>
                              <th> # </th>
                              <th> Parent </th>
                              <th> Title </th>
                              <th> Title Ru </th>
                              <th> Status </th>
                              <th class="text-right"> Actions </th>
                          </tr>
                          </thead>
                          <tbody>
                              @foreach($models as $key => $model)
                              <tr id="row_{{ $model->id}}">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $model->parentMenu->title_uz??'(Пусто)' }}</td>
                                <td>{{ $model->title_uz }}</td>
                                <td>{{ $model->title_ru }}</td>
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
                              <td class="text-right">
                                <a class="btn btn-success btn-link m-0 p-1 editLink" href="#" rel="tooltip" data-id="{{ $model->id }}" title="" data-toggle="modal" data-target="#edit">
                                  <i class="material-icons">edit</i>
                                  <div class="ripple-container"></div>
                                </a>
                                <a class="btn btn-danger btn-link m-0 p-1 deleteLink" href="#" rel="tooltip" data-id="{{ $model->id }}" title="" data-toggle="modal" data-target="#delete">
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
                  <form class="form" method="POST" action="{{ route('store-dep-sub-menu') }}" enctype="multipart/form-data">
                    @csrf

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">subdirectory_arrow_right</i></div>
                          </div>
                          <select class="form-control" data-style="btn btn-link" id="storeAddParentMenu" name="parent" data-live-search="true" required>
                          <option value="" disabled selected> Select Parent Menu </option>
                            @foreach($parent as $value)
                              <option value="{{ $value->id }}"> {{ $value->title_uz }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

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
                            <div class="input-group-text"><i class="material-icons">sort</i></div>
                          </div>
                            <input type="number" class="form-control" name="sort" placeholder="Sort..." required>
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

  <!-- Search Parent Modal -->
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
                  <form class="form" method="POST" action="{{ route('admin-menu-dep-sub') }}">
                    @csrf
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">subdirectory_arrow_right</i></div>
                          </div>
                          <select class="form-control" data-style="btn btn-link" id="parentMenu" name="parent" data-live-search="true">
                            <option value=""> Select Parent Menu </option>

                            @foreach($parent as $value)
                              @if($value->id == ($parentId??''))
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
                            <input type="text" id="searchTitle_uz" class="form-control" name="title_uz" placeholder=" Title uz..." value="{{ $title_uz??'' }}">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="searchTitle_ru" class="form-control" name="title_ru" placeholder=" Title ru..." value="{{ $title_ru??'' }}">
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
                  <form id="updateForm" class="form" method="POST" action="{{ route('update-dep-sub-menu') }}" enctype="multipart/form-data">
                    @csrf
                      <input type="text" name="id" id="sub_menu_id" hidden>
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">subdirectory_arrow_right</i></div>
                          </div>
                          <select class="form-control" data-style="btn btn-link" id="updateParentMenu" name="parent" required>
                            @foreach($parent as $value)
                              <option value="{{$value->id}}"> {{ $value->title_uz }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

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
                            <div class="input-group-text"><i class="material-icons">sort</i></div>
                          </div>
                            <input type="number" id="updateSort" class="form-control" name="sort" placeholder="Sort..." required>
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

                        <h4 class="text-center"><i class="material-icons" style="color: #FB8C00">warning</i> </h4>
                        <h4 class="text-center">Are you sure you want to delete? </h4>
                        <h4 class="text-center">Deleting the item also causes its sub which means they also will be deleted permanently. </h4>

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
        url: '/admin-menu-dep-sub/' + itemId,
        data: {
          _token: csrf_token,
          id    : itemId
        },
        type: 'get',
        success: function(result){
          let oldSubMenu = result['oldSubMenu']
          console.log(result)
          // Reset form befor uploading old document info
          $("#updateForm").trigger('reset');

          // Storing old document info into Update Modal
          
          $('#sub_menu_id').val(oldSubMenu.id)
          $('#updateTitle_uz').val(oldSubMenu.title_uz)
          $('#updateTitle_ru').val(oldSubMenu.title_ru)
          $('#updateSort').val(oldSubMenu.sort)

          if(oldSubMenu.status){
            $('#updateStatusActive').prop('checked',true)
          }
          else{
            $('#updateStatusPassive').prop('checked', true)
          } 
          
          $('#updateParentMenu').selectpicker('val',oldSubMenu.depart_id);
          $('#updateParentMenu').selectpicker('refresh');


        },
        error: function(error){
          console.log(error)
        }
      })



    })

    $('.deleteLink').click(function(){
      let itemId = $(this).data('id')

      $("#deleteConfirm").unbind().click(function() {

        $.ajax({
          url: '/admin-menu-dep-sub/' + itemId,
          data: {
            _token : csrf_token,
          },
          type: 'delete',

          success: function(result) {
            $('#delete').modal('toggle')
            $('#responseModal .modal-title').text('Success')
            $('#responseModal .modal-footer button').removeClass('btn-danger').addClass('btn-success')
            $('#responseModal').modal('toggle')
            $('#responseModal .modal-body p').text(result)
            $('#row_'+itemId).remove()

            setTimeout(function() {$('#responseModal').modal('hide')}, 1500)
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
