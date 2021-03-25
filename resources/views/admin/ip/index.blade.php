@extends('layouts.app', ['activePage' => 'ip-phone', 'titlePage' => __('Ip Phone Numbers'), 'show' => 'ip'])

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
                <h4 class="card-title ">Ip Management</h4>
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
                              <th> Department </th>
                              <th> Sub Department</th>
                              <th> Name</th>
                              <th> Job</th>
                              <th> Ip</th>
                              <th> Status</th>
                              <th class="text-right"> Actions </th>
                          </tr>
                          </thead>
                          <tbody>
                              @foreach($models as $key => $model)
                              <tr id="row_{{ $model->id}}">
                                <td>{{ $key+1}}</td>
                                <td>{{ $model->department->title_uz??'(Пусто)' }}</td>
                                <td>{{ $model->sub_department->title_uz??'(Пусто)' }}</td>
                                <td>{{ $model->fio }}</td>
                                <td>{{ $model->descr }}</td>
                                <td>{{ $model->ip }}</td>
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

  
  <!-- Add Modal -->
  <div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="card card-signup card-plain">
            <div class="modal-header">
              <h5 class="modal-title card-title">Add New Ip Contact ...</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="material-icons">clear</i>
              </button>
            </div>

            <div class="modal-body">
              
              <div class="row">
                <div class="col-md-10 m-auto">
                  <form class="form" method="POST" action="{{ route('store-ip') }}" enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">menu</i></div>
                          </div>
                          <select class="form-control" data-style="btn btn-link" id="selectDep" name="depart_id" data-live-search="true" required>
                            <option value="" disabled selected> Select Branch </option>
                            @foreach($parentDep as $value)
                              <option value="{{ $value->id }}"> {{ $value->title_uz }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">subdirectory_arrow_right</i></div>
                          </div>
                          <select class="form-control" data-style="btn btn-link" id="selectSubDep" name="sub_depart_id" data-live-search="true" required>
                            <option value="" disabled selected>Select Department</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" class="form-control" name="fio" placeholder="Name..." required>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" class="form-control" name="descr" placeholder="Occupation..." required>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                          </div>
                            <input type="number" class="form-control" name="ip" placeholder="IP Number" min="0" max="10000000000000" required>
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
                  <form class="form" method="POST" action="{{ route('admin-ip') }}">
                    @csrf
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">menu</i></div>
                          </div>
                          <select class="form-control" data-style="btn btn-link" id="searchDepart" name="depart_id" data-live-search="true">
                            <option value=""> Select Parent Menu </option>
                            @foreach($parentDep as $value)
                              @if($value->id == ($depart_id??''))
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
                            <div class="input-group-text"><i class="material-icons">subdirectory_arrow_right</i></div>
                          </div>
                          <select class="form-control" data-style="btn btn-link" id="searchSubDepart" name="sub_depart_id" data-live-search="true">
                            <option value=""> Select Sub Department</option>
                            @foreach($childDep as $value)
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
                            <input type="text" class="form-control" id="search_fio" name="fio" placeholder="Name..." value="{{ $fio??'' }}">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">title</i></div>
                          </div>
                            <input type="text" class="form-control" id="search_descr" name="descr" placeholder="Occupation..." value="{{ $descr??'' }}">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                          </div>
                            <input type="number" class="form-control" id="search_ip" name="ip"  min="0" max="10000000000000" placeholder="IP Number" value="{{ $ip??'' }}">
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
              <h5 class="modal-title card-title">Update Ip phone details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="material-icons">clear</i>
              </button>
            </div>

            <div class="modal-body">
              
              <div class="row">
                <div class="col-md-10 m-auto">
                  <form class="form" method="POST" action="{{ route('update-ip')}}">
                    @csrf

                    <input type="text" name="id" id="ip_id" hidden>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">menu</i></div>
                        </div>
                        <select class="form-control" data-style="btn btn-link" id="updateDepart" name="depart_id" data-live-search="true">
                          <option id="defaultMenu" value="" disabled selected>Select Department</option>
                          @foreach($parentDep as $value)
                              @if($value->id == ($depart_id??''))
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
                          <div class="input-group-text"><i class="material-icons">subdirectory_arrow_right</i></div>
                        </div>
                        <select class="form-control" data-style="btn btn-link" id="updateSubDepart" name="sub_depart_id" data-live-search="true">
                          <option id="defaultSubMenu" value="" disabled selected>Select Sub Department</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                          <input type="text" class="form-control" id="update_fio" name="fio" placeholder="Name..." value="{{ $fio??'' }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                          <input type="text" class="form-control" id="update_descr" name="descr" placeholder="Occupation..." value="{{ $descr??'' }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                        </div>
                          <input type="number" class="form-control" id="update_ip" name="ip" min="0" max="10000000000000" placeholder="IP Number" value="{{ $ip??'' }}">
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

    $('select').selectpicker()

    // On adding 
    $('#selectDep').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
      
      let optionValue = $(this).val()

      $('#selectSubDep option').remove()
      $.ajax({
        url: '/admin-ip/fetch-sub-dep/'+ optionValue,
        type: 'get',
        success: function(result){

          let arr = result['sub_menu']
          let newOptions = '<option id="defaultMenu" value="" disabled selected>Select Parent Menu</option>'

          $.each(arr, function(index, val){
            newOptions += '<option value="'+val.id+'">'+val.title_uz+'</option>'
          })

          $('#selectSubDep').append(newOptions).selectpicker('refresh')

        },
        error: function(e){
          console.log(e)
        }
      })

    })

    // On saerching 
    $('#searchDepart').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
      
      let optionValue = $(this).val()

      $('#searchSubDepart option').remove()
      $.ajax({
        url: '/admin-ip/fetch-sub-dep/'+ optionValue,
        type: 'get',
        success: function(result){

          let arr = result['sub_menu']
          let newOptions = '<option id="defaultMenu" value="" disabled selected>Select Sub Menu</option>'

          $.each(arr, function(index, val){
            newOptions += '<option value="'+val.id+'">'+val.title_uz+'</option>'
          })

          $('#searchSubDepart').append(newOptions).selectpicker('refresh')

        },
        error: function(e){
          console.log(e)
        }
      })

    })

    // On updating 
    $('#updateDepart').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
      
      let optionSubValue = $(this).data('id')
      let optionValue = $(this).val()

      $('#updateSubDepart option').remove()
      $.ajax({
        url: '/admin-ip/fetch-sub-dep/'+ optionValue,
        type: 'get',
        success: function(result){

          let arr = result['sub_menu']
          let newOptions = '<option id="defaultMenu" value="" disabled selected>Select Sub Menu</option>'

          $.each(arr, function(index, val){
            newOptions += '<option value="'+val.id+'">'+val.title_uz+'</option>'
          })

          $('#updateSubDepart').append(newOptions).selectpicker('refresh')
          
          $('#updateSubDepart').selectpicker('refresh')
          $('#updateSubDepart').selectpicker('render')

          $('#updateSubDepart').selectpicker('val', optionSubValue)

          $('#updateSubDepart').selectpicker('refresh')
          $('#updateSubDepart').selectpicker('render')


        },
        error: function(e){
          console.log(e)
        }
      })

    })
    

    // Update the Item
    $('.editLink').click(function() {
      
      // Clear options before call
      $('#updateSubDepart option').remove().selectpicker('refresh')

      let itemId = $(this).data('id')

      $.ajax({
        url: '/admin-ip/' + itemId,
        data: {
          _token: csrf_token,
          id    : itemId
        },
        type: 'get',
        success: function(result){
          let old             = result['oldIp']
          let current_dep     = result['dep']          
          let current_sub_dep = result['sub_dep']
          let dep_list        = result['dep_list']  
          let sub_dep_list    = result['sub_dep_list']  
          let menuOptions     = ''
          let subMenuOptions  = ''
          
          $('#ip_id').val(itemId);
          $('#update_fio').val(old.fio)
          $('#update_descr').val(old.descr)
          $('#update_ip').val(old.ip)

          $('#updateDepart').data('id',current_sub_dep.id); //setter
          $('#updateDepart').selectpicker('val', old.depart_id)
          // $('#updateSubDepart').selectpicker('val', current_sub_dep)


          if(old.status){
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

      const button = document.querySelector('#deleteConfirm');
      button.addEventListener('click', handleClickEvent)

      function handleClickEvent(e) {
        e.preventDefault();
        $.ajax({
          url: '/admin-ip/' + itemId,
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
      }
    })

  })

  // Clear Saerch Filter
  $('#clearSearchForm').click(function(){
    $("#searchDepart").selectpicker('val','')
    $("#searchSubDepart").selectpicker('val','')
    $("#search_fio").val('')
    $("#search_descr").val('')
    $("#search_ip").val('')
    $("#searchStatusActive").prop('checked', false)
    $("#searchStatusPassive").prop('checked', false)

  })
</script>


@endsection
