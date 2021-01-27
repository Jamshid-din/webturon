@extends('layouts.app', ['activePage' => 'news', 'titlePage' => __('News Blog'), 'show' => 'news'])

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
                <h4 class="card-title ">News</h4>
                <p class="card-category"> <!-- Here you can manage ip list --></p>
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
                          <thead class="text-primary">
                          <tr>
                              <th> # </th>
                              <th> Image Preview </th>
                              <th> Title </th>
                              <th> Text</th>
                              <th> Status</th>
                              <th> Created at</th>
                              <th class="text-right"> Actions </th>
                          </tr>
                          </thead>
                          <tbody>
                              @foreach($models as $key => $model)
                              <tr id="row_{{ $model->id}}">
                                <td>{{ $key+1}}</td>
                                <td>
                                    <img style="display:block;" width="150px" height="150px" src="{{ asset('storage/media/'.$model->media->hash??'') }}" />
                                </td>
                                <td>{{ $model->title??'(Пусто)' }}</td>
                                <td>{{ $model->text??'(Пусто)' }}</td>
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
                    <form class="form" method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                            <input type="text" class="form-control" name="title" placeholder="Title..." value="{{ old('title') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                        <textarea id="form7" class="md-textarea form-control" rows="10" name="text" value="{{ old('text') }}" placeholder="Text of the Post here ..." required></textarea>
                        </div>
                    </div>

                    <div class="form-group form-file-upload form-file-simple">
                        <div class="input-group">
                        <div class="input-group-text"><i class="material-icons">cloud_upload</i></div>
                        <input type="text" name="filename" class="form-control inputFileVisible" placeholder="Upload Media ..." required >
                        <input type="file" name="file" class="inputFileHidden" >
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
  
  <!-- Search Modal -->
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
                  <form class="form" method="POST" action="{{ route('news.search') }}">
                    @csrf

                    <div class="form-group">
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                            <input type="text" id="searchTitle" class="form-control" name="title" placeholder="Title..." value="{{ $title??'' }}">
                        </div>
                    </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">done_all</i></div>
                          </div>
                          <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="status" id="searchStatusActive" value="1" {{ ($status??'0') ? 'checked':'' }}> Active
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
                  <form class="form" method="POST" action="{{ route('news.update', 0) }}" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}

                    <input type="text" name="id" id="updateId" hidden>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                          <input type="text" class="form-control" id="updateTitle" name="title" placeholder="Name..." value="{{ $title??'' }}">
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                        <textarea id="updateText" class="md-textarea form-control" rows="10" name="text" value="{{ old('text') }}" placeholder="Text of the Post here ..." required></textarea>
                        </div>
                    </div>

                    <div class="form-group form-file-upload form-file-simple">
                        <div class="input-group">
                        <div class="input-group-text"><i class="material-icons">cloud_upload</i></div>
                        <input id="updateFilename" type="text" name="filename" class="form-control inputFileVisible" placeholder="Upload Media ..." required >
                        <div class="input-group-text"><a href="#" class="clearField"><i class="material-icons">clear</i></a></div>
                        <input id="updateFile" type="file" name="file" class="inputFileHidden" >
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">done_all</i></div>
                        </div>
                        <div class="form-check form-check-radio form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="status" id="updateStatusActive" value="1" {{ ($status??'') ? 'checked':'' }}> Active
                            <span class="circle">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>

                        <div class="form-check form-check-radio form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="status" id="updateStatusPassive" value="0" {{ (($status??'1') == 0) ? 'checked':'' }}> Passive
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
                  <form class="form" method="" action="">

                    <h4 class="text-center">Are you sure you what to delete?</h4>
                    
                    <input type="number" class="form-control" name="id" value="" hidden>

                    <div class="modal-footer justify-content-center">
                      <a type="submit" id="deleteConfirm" class="btn btn-danger btn-round text-white" data-boolval="true">Delete</a>
                    </div>

                  </form>
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
    let csrf_token = $('meta[name="csrf-token"]').attr('content')

    // Update the Item
    $('.editLink').click(function() {

      let itemId = $(this).data('id')

      $.ajax({
        url: '/news/' + itemId,
        data: {
          _token: csrf_token,
          id    : itemId
        },
        type: 'get',
        success: function(result){
          let model = result['model']
          let file  = result['file']
          
          $('#updateId').val(model.id)
          $('#updateTitle').val(model.title)
          $('#updateText').val(model.text)
          $('#updateFilename').val(file.name)

          if(model.status){
            $('#updateStatusActive').prop('checked',true)
          }
          else{
            $('#updateStatusPassive').prop('checked', true)
          } 


        },
        error: function(e){
          console.log(e)
        }
          
      })


    })

    // Delete the Item
    $('.deleteLink').click(function() {
      let itemId = $(this).data('id')

      $("#deleteConfirm").unbind().click(function() {

        $.ajax({
          url: '/news/' + itemId,
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

  })

  // Clear files
  $('.clearField').click(function(){
    $('#updateFilename').val('')
    $('#updateFile').val('')
  })

  // Clear Saerch Filter
  $('#clearSearchForm').click(function(){
    $("#searchTitle").val('')
    $("#searchStatusActive").prop('checked', false)
    $("#searchStatusPassive").prop('checked', false)
  })
</script>


@endsection
