@extends('layouts.app', ['activePage' => 'personal-menu', 'titlePage' => __('Personal Menu'), 'show' => 'menu'])

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
                <ul class="nav nav-tabs" id="pills-tab">             
                    <li class="nav-item">
                        <a class="nav-link text-white active" id="pills-menu-tab" href="{{ route('admin-menu-personal') }}">Parent Menu </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" id="pills-submenu-tab" href="{{ route('admin-menu-personal-sub') }}">Sub Menu</a>
                    </li>
                </ul>                
                <p class="card-category"> <!-- Here you can manage personal docuements --></p>
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
                            <th> Title </th>
                            <th> Title Ru </th>
                            <th> Sort </th>
                            <th> Status </th>
                            <th class="text-right"> Actions </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($models as $key => $model)
                            <tr id="row_{{ $model->id}}">
                            <td>{{ $key+1}}</td>
                            <td>{{ $model->title_uz }}</td>
                            <td>{{ $model->title_ru }}</td>
                            <td>{{ $model->sort }}</td>
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
                  <form class="form" method="POST" action="{{ route('store-personal-menu') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                          <input type="text" class="form-control" name="title_uz" placeholder="Menu Title UZ..." required>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                          <input type="text" class="form-control" name="title_ru" placeholder="Menu Title RU..." required>
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
                            <input class="form-check-input" type="radio" name="status" id="storeActiveStatus" value="1" checked> Active
                            <span class="circle">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>

                        <div class="form-check form-check-radio form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="status" id="storePassiveStatus" value="0"> Passive
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
                  <form id="searchForm" class="form" method="POST" action="{{ route('admin-menu-personal') }}">
                    @csrf
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="searchTitle_uz" class="form-control" name="title_uz" placeholder="Menu Title Uz..." value="{{ $title_uz??'' }}">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="searchTitle_ru" class="form-control" name="title_ru" placeholder="Menu Title Ru..." value="{{ $title_ru??'' }}">
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
              <h5 class="modal-title card-title">Update Menu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="material-icons">clear</i>
              </button>
            </div>

            <div class="modal-body">
              
              <div class="row">
                <div class="col-md-10 m-auto">
                  <form class="form" method="POST" action="{{ route('update-personal-menu') }}" enctype="multipart/form-data">
                    @csrf
                      <input type="text" id="menu_id" name="id" hidden required>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="updateTitle_uz" class="form-control" name="title_uz" placeholder="Menu Title UZ..." required>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" id="updateTitle_ru" class="form-control" name="title_ru" placeholder="Menu Title RU..." required>
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
                              <input class="form-check-input" type="radio" name="status" id="updateActiveStatus" value="1" checked> Active
                              <span class="circle">
                                  <span class="check"></span>
                              </span>
                            </label>
                          </div>

                          <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="status" id="updatePassiveStaus" value="0"> Passive
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
                        <h4 class="text-center">Deleting the item also causes its sub menus and files which means they also will be deleted permanently. </h4>

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
  // Token
  var csrf_token = $('meta[name="csrf-token"]').attr('content');

  $('.deleteLink').click(function(){
    let itemId = $(this).data('id')

    $("#deleteConfirm").unbind().click(function() {

      $.ajax({
        url: '/admin-menu-personal/' + itemId,
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

  $('.editLink').click(function(){
    let itemId = $(this).data('id')

    // Reset the form before uploading old menu
    $("#updateForm").trigger('reset');

    $.ajax({
      url: '/admin-menu-personal/' + itemId,
      type: 'GET',
      data: {
        _token: csrf_token
      },
      success: function(result){

        let oldMenu = result['oldMenu']
        
        $('#menu_id').val(itemId)
        $('#updateTitle_uz').val(oldMenu.title_uz)
        $('#updateTitle_ru').val(oldMenu.title_ru)
        $('#updateSort').val(oldMenu.sort)
        if(oldMenu.status){
          $('#updateActiveStatus').prop('checked', true)
        }else{
          $('#updatePassiveStaus').prop('checked', true)
        }

      },
      error: function(error){
        console.log(error.statusText)
      }
    })

  })

  // End of Ready Function

  // Clear Saerch Filter
  $('#clearSearchForm').click(function(){
    $("#searchTitle_uz").val('');
    $("#searchTitle_ru").val('');
    $("#searchStatusActive").prop('checked', false);
    $("#searchStatusPassive").prop('checked', false);

  })
</script>


@endsection
