@extends('layouts.app', ['activePage' => 'archive', 'titlePage' => __('Archive'), 'show' => 'document'])

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
              <h4 class="card-title ">Archive Documents</h4>
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
                      <th class="w-25"> Parent </th>
                      <th class="w-75"> Title </th>
                      <th> Status</th>
                      <th> Creation date</th>
                      <th class="text-right"> Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($models as $key => $model)
                      <tr id="row_{{ $model->id }}">
                        <td>{{ $key+1}}</td>
                        <td>{{ (($model->menu->parent_id??0) != 0) ? $model->menu->parents($model->menu->parent_id??0) : '' }} {{ $model->menu->title_uz??''}}</td>
                        <td>{{ $model->doc_title }}</td>
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
                          <a class="btn btn-success btn-link editLink" href="#" rel="tooltip" data-id="{{ $model->id }}" title="" data-toggle="modal" data-target="#edit">
                            <i class="material-icons">edit</i>
                            <div class="ripple-container"></div>
                          </a>
                          <a class="btn btn-danger btn-link deleteLink" href="#" rel="tooltip" data-id="{{ $model->id }}" title="" data-toggle="modal" data-target="#delete">
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
                <form class="form" method="POST" action="{{ route('store-arch-doc') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">title</i></div>
                      </div>
                        <input type="text" class="form-control" name="doc_title" placeholder="Document Title..." required>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">title</i></div>
                      </div>
                      <textarea type="text" class="form-control" name="doc_text" placeholder="Document Text..."></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">menu</i></div>
                      </div>
                      <select class="form-control" data-style="btn btn-link selectDep" id="selectDep" name="menu_id" virtualScroll="true" data-live-search="true" required>
                        <option value="" disabled selected>Select Parent Menu</option>
                        @foreach($menu_list as $value)
                          <option value="{{ $value->id }}"> {{ $value->parents($value->id) }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <!-- <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">subdirectory_arrow_right</i></div>
                      </div>
                      <select class="form-control" data-style="btn btn-link" id="selectSubDep" name="sub_menu_id" data-live-search="true" required>
                        <option value="" disabled selected>Select Sub Menu</option>
                      </select>
                    </div>
                  </div> -->

                  <div class="form-group form-file-upload form-file-simple">
                    <div class="input-group">
                      <div class="input-group-text"><i class="material-icons">cloud_upload</i></div>
                      <input type="text" name="filename" class="form-control inputFileVisible" placeholder="Scan or pdf ...">
                      <input type="file" name="file" class="inputFileHidden" >
                    </div>
                  </div>

                  <div class="form-group form-file-upload form-file-simple">
                    <div class="input-group">
                      <div class="input-group-text"><i class="material-icons">cloud_upload</i></div>
                      <input type="text" name="e-filename" class="form-control inputFileVisible" placeholder="Doc or xls ...">
                      <input type="file" name="e-file" class="inputFileHidden" >
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
                      <form id="searchForm" class="form" method="POST" action="{{ route('admin-docs-archive') }}">
                        @csrf

                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="material-icons">menu</i></div>
                            </div>
                            <select class="form-control" data-style="btn btn-link selectDep" id="searchDep" name="menu_id" virtualScroll="true" data-live-search="true">  
                              <option value="" disabled selected> Select Parent Menu </option>
                              @foreach($menu_list as $value)
                                @if($value->id == ($menu_id??''))
                                  <option value="{{ $value->id }}" selected> {{ $value->parents($value->id) }} </option>
                                @else
                                  <option value="{{ $value->id }}"> {{ $value->parents($value->id)  }} </option>
                                @endif
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <!-- <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="material-icons">subdirectory_arrow_right</i></div>
                            </div>
                            <select class="form-control" data-style="btn btn-link" id="searchSubDep" name="sub_menu_id" data-live-search="true">
                              <option value="" disabled selected>Select Sub Menu</option>
                             
                            </select>
                          </div>
                        </div> -->


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
                                <div class="input-group-text"><i class="material-icons">title</i></div>
                              </div>
                                <textarea type="text" id="searchText" class="form-control" name="text" placeholder="Document Text..." value="{{ $text??'' }}"></textarea>
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
                <form class="form" id="updateForm"  method="POST" action="{{ route('update-arch-doc') }}" enctype="multipart/form-data">
                  @csrf
                    <input type="text" name="id" id="doc_id" hidden>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                          <input id="updateInputTitle" type="text" class="form-control" name="doc_title" placeholder="Document Title..." required>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">title</i></div>
                        </div>
                          <textarea id="updateInputText" type="text" class="form-control" name="doc_text" placeholder="Document Text..."></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">menu</i></div>
                        </div>
                        <select class="form-control" data-style="btn btn-link" id="updateParentMenu" name="menu_id" required  data-live-search="true">
                            @foreach($menu_list as $value)
                              <option value="{{$value->id}}"> {{ $value->parents($value->id) }} </option>
                            @endforeach
                          </select>
                      </div>
                    </div>

                    <!-- <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">subdirectory_arrow_right</i></div>
                        </div>
                        <select class="form-control" data-style="btn btn-link" id="updateSubDep" name="sub_menu_id" data-live-search="true" required>
                          <option id="defaultSubMenu" value="" disabled selected>Select Sub Menu</option>
                        </select>
                      </div>
                    </div> -->

                    <div class="form-group form-file-upload form-file-simple">
                      <div class="input-group">
                        <div class="input-group-text"><i class="material-icons">cloud_upload</i></div>
                        <input id="updateFilename" type="text" name="filename" class="form-control inputFileVisible" placeholder="Scan or pdf ..." readonly>
                        <div class="input-group-text"><a href="#" class="clearField"><i class="material-icons">clear</i></a></div>
                        <input type="file" name="file" class="inputFileHidden">
                      </div>
                    </div>

                    <div class="form-group form-file-upload form-file-simple">
                      <div class="input-group">
                        <div class="input-group-text"><i class="material-icons">cloud_upload</i></div>
                        <input id="updateEFilename" type="text" name="e-filename" class="form-control inputFileVisible" placeholder="Doc or xls ..." readonly>
                        <input type="file" name="e-file" class="inputFileHidden">
                        <div class="input-group-text"><a href="#" class="clearEField"><i class="material-icons">clear</i></a></div>
                      </div>
                    </div>
                    
                  
                    <div class="form-group">
                      <div class="input-group">

                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="material-icons">done_all</i></div>
                        </div>

                        <div class="form-check form-check-radio form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="status" id="updateStatus1" value="1"> Active
                            <span class="circle">
                                <span class="check"></span>
                            </span>
                          </label>
                        </div>

                        <div class="form-check form-check-radio form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="status" id="updateStatus2" value="0"> Passive
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

    // // On adding document
    // $('#selectDep').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

    //   let optionValue = $(this).val()
    //   $('#selectSubDep option').remove()
    //   $.ajax({
    //     url: '/admin-menu-archive-sub/fetch-sub/'+ optionValue,
    //     type: 'get',
    //     success: function(result){

    //       let sub_menu = result['sub_menu']
    //       let newOptions = '<option id="defaultMenu" value="" disabled selected>Select Sub Menu</option>'

    //       $.each(sub_menu, function(index, val){
    //         newOptions += '<option value="'+val.id+'">'+val.title_uz+'</option>'
    //       })

    //       $('#selectSubDep').append(newOptions).selectpicker('refresh')

    //     },
    //     error: function(e){
    //       console.log(e)
    //     }
    //   })

    // })

    // On searching document
    // $('#searchDep').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

    //   let optionValue = $(this).val()
    //   $('#searchSubDep option').remove()
    //   $.ajax({
    //     url: '/admin-menu-archive-sub/fetch-sub/'+ optionValue,
    //     type: 'get',
    //     success: function(result){

    //       let sub_menu = result['sub_menu']
    //       let newOptions = '<option id="defaultMenu" value="" disabled selected>Select Sub Menu</option>'

    //       $.each(sub_menu, function(index, val){
    //         newOptions += '<option value="'+val.id+'">'+val.title_uz+'</option>'
    //       })

    //       $('#searchSubDep').append(newOptions).selectpicker('refresh')

    //     },
    //     error: function(e){
    //       console.log(e)
    //     }
    //   })

    // })

    // // On updating document
    // $('#updateDep').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
      
    //   let optionValue = $(this).val()
    //   let optionSubValue = $('#updateSubDep').val()
    //   let optionSubText = $('#updateSubDep').text()
      
    //   $('#updateSubDep option').remove()

    //   $('#updateSubDep').selectpicker('refresh')
    //   $.ajax({
    //     url: '/admin-menu-archive-sub/fetch-sub/'+ optionValue,
    //     type: 'get',
    //     success: function(result){

    //       let sub_menu = result['sub_menu']
    //       let newOptions = ''

    //       $.each(sub_menu, function(index, val){
    //         if(val.id == optionSubValue){
    //           newOptions += '<option value="'+val.id+'" selected>'+val.title_uz+'</option>'
    //         }else{
    //           newOptions += '<option value="'+val.id+'">'+val.title_uz+'</option>'
    //         }
    //       })
    //       $('#updateSubDep').append(newOptions)
    //       $('#updateSubDep').selectpicker('refresh')
    //       $('#updateSubDep').selectpicker('val', optionSubValue)
    //       $('#updateSubDep').selectpicker('refresh')

    //     }
    //   })

    // })

    // Delete list item
    $(".deleteLink").click( function () {
      let itemId = $(this).data('id')

      $("#deleteConfirm").unbind().click(function() {

        $.ajax({
          url: '/admin-docs-arch/' + itemId,
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
      // Clear options before call
      $('#updateDep option').remove().selectpicker('refresh')
      $('#updateSubDep option').remove().selectpicker('refresh')

      let itemId = $(this).data('id')

      $.ajax({
        url: '/admin-docs-arch/' + itemId,
        data: {
          _token: csrf_token,
          id    : itemId
        },
        type: 'get',
        success: function(result){
          let scanFile = result['scanFile']
          let electronicFile = result['electronicFile']
          let oldArch = result['oldArch']
          let menu = result['menu']
          let subMenu = result['subMenu']
          let currentMenu = ''
          let currentSubMenu = ''
          let menuOptions = ''
          let subMenuOptions = ''
          
          $.each( menu , function( index, value ) {
            if(value.id === oldArch.doc_arch_menu_id){
              currentMenu = value
            }
          });
          $.each( subMenu , function( index, sub_value ) {
            if(sub_value.id == oldArch.doc_sub_arch_menu_id){
              currentSubMenu = sub_value
            }
          });

          // Reset form befor uploading old document info
          $("#updateForm").trigger('reset');

          // Storing old document info into Update Modal
          
          $('#doc_id').val(oldArch.id)
          $('#updateInputTitle').val(oldArch.doc_title)
          $('#updateInputText').val(oldArch.doc_text)

          if(scanFile) $('#updateFilename').val(scanFile.doc_name)
          if(electronicFile) $('#updateEFilename').val(electronicFile.doc_name)
            
          

          if(oldArch.status){
            $('#updateStatus1').prop('checked',true)
          }
          else{
            $('#updateStatus2').prop('checked', true)
          } 



          $.each(menu, function(index, val){
            if(val.id == currentMenu.id){
              menuOptions += '<option value="'+val.id+'" selected>'+val.title_uz+'</option>'
            }else{
              menuOptions += '<option value="'+val.id+'">'+val.title_uz+'</option>'
            }
          })
          $.each(subMenu, function(index, val){
            if(val.id == currentSubMenu.id){
              subMenuOptions += '<option value="'+val.id+'" selected>'+val.title_uz+'</option>'
            }else{
              subMenuOptions += '<option value="'+val.id+'">'+val.title_uz+'</option>'
            }
          })

          $('#updateDep').append(menuOptions)
          $('#updateSubDep').append(subMenuOptions)

          $('#updateDep').selectpicker('val', currentMenu.id);
          $('#updateSubDep').selectpicker('val', currentSubMenu.id);

          
          $('select').selectpicker('refresh');
          $('select').selectpicker('render');

          $('#updateParentMenu').selectpicker('val',oldArch.doc_menu_id);
          $('#updateParentMenu').selectpicker('refresh');
        },
        error: function(error){
          console.log(error)
        }
      })
    })

    // Clear files
    $('.clearField').click(function(){
      $('#updateFilename').val('')
    })
    $('.clearEField').click(function(){
      $('#updateEFilename').val('')
    })

  })
  // End of Ready Function

  // Clear Saerch Filter
  $('#clearSearchForm').click(function(){
    $('#searchSubDep').selectpicker('val', '')
    $("#searchTitle").val('');
    $("#searchText").val('');
    $("#searchStatusActive").prop('checked', false);
    $("#searchStatusPassive").prop('checked', false);
    $('#searchDep').selectpicker('val', '')

  })

</script>
@endsection
