@extends('home')
@section('content')
    <!--FAQS AREA-->
    
    <section class="faqs-area section-padding wow fadeIn" id="myDiv">
        
        <div class="container" style="width: 80%;">
            <div class="row col-lg-12">
                <div class="col-lg-8">
                    <div class="faqs-left-img">

                        <h1>Softs</h1>
                        <table id="example" class="display">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">#</th>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Created at</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            
                            <tfoot>
                                <tr>
                                    <th style="width: 10%;">#</th>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Created at</th>
                                    <th>Download</th>                                 
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="faqs-list">
                        <h3>Фильтр</h3>

                        <div class="panel-group" id="accordion">
                            @foreach($menus as $key => $value)
                            <div class="panel {{ ($key === 0) ? 'active':'' }}">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="menu-soft" data-key="{{ $key }}" data-id="{{ $value->id }}" data-toggle="collapse" data-parent="#accordion" href="#faqs_{{ $key }}"><i class="fa fa-minus"></i> {{ $value->title_uz }} </a>
                                    </h4>
                                </div>

                                <div id="faqs_{{ $key }}" class="panel-collapse {{ ($key === 0) ? 'in':'collapse' }}">
                                @foreach($models as $k => $sub_value)
                                    @if($sub_value->menu_id === $value->id)
                                    <p>
                                        <i class="fa fa-bars"></i>
                                        <a href="#" class="get-sub" data-id="{{ $sub_value->id }}"> {{ $sub_value->name }}  </span>
                                    </p>
                                    @endif
                                @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                
                
            </div>
        </div>
    </section>
    <!--FAQS AREA END-->

    <script src="{{ asset ("js/vendor/jquery-1.12.4.min.js") }}"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            // Define Token
            let _token = $('meta[name="csrf-token"]').attr('content')

            let key = $('.menu-soft').data('key')
            let id = null

            if(key === 0){
                id = $('.menu-soft').data('id')
            }else{
                id = 1;
            }

            // To store response data from ajax
            $.ajax({
                url: "/soft/fetch_data/" + id,
                type: "GET",
                beforeSend: function(){
                    $('#example').fadeOut();
                },
                success: function(result){
                    let data = result.models.data

                    // Fill Datatable with default values
                    let table = $('#example').DataTable( {
                        destroy: true,
                        proccessing: true,
                        data: data,
     
                        columns : [
                            { data: "id" },
                            { data: "name"},
                            { data: "size"},
                            { data: "created_at"},
                            {
                                sortable: false,
                                "render": function ( data, type, full, meta ) {
                                    return '<a href="{{ url("/soft-download")}}/'+full.id+'" class=\"btn btn-info details-button\"> <i class=\"fa fa-download\" aria-hidden=\"true\"> </i> download... </a>';
                                }
                            },
                        ],
                        order: [[ 0, 'asc' ]],
                        responsive  : true,
                        fixedHeader : true,
                        processing  : true,
                        pageLength  : 10
                    });

                    // The First Column Autoincrement 
                    table.on( 'order.dt search.dt', function () {
                        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                            cell.innerHTML = i+1;
                        } );
                    } ).draw();

                    // On click button on the table
                    $('#example tbody').on( 'click', 'button', function () {
                        let data = table.row( $(this).parents('tr') ).data()                        
                        console.log(data)
                        $.ajax({
                            url: "/soft-download/" + data.id,
                            type: "GET",
                            success: function(res){
                                console.log(res)
                            },
                            error: function(e) {
                                console.log(e)
                            }
                        })
                    })

                },
                complete: function(){
                    $('#example').fadeIn();
                },
                error: function(e) {
                    console.log(e)
                }
                
            });


        });

        // When Department is choosen from right menu of the departments
        $(".menu-soft").unbind().click(function(){

            let id = $(this).data("id")

            // To store response data from ajax
            $.ajax({
                "url": "/soft/fetch_data/" + id,
                'type': "GET",
                beforeSend: function(){
                    $('#example').fadeOut();
                },
                success: function(result){
                    let data = result.models.data

                    // Fill Datatable with default values
                    let table = $('#example').DataTable( {
                        destroy: true,
                        proccessing: true,
                        data: data,
                        columns : [
                            { data: "id" },
                            { data: "name"},
                            { data: "size"},
                            { data: "created_at"},
                            {
                                sortable: false,
                                "render": function ( data, type, full, meta ) {
                                    return '<a href="{{ url("/soft-download")}}/'+full.id+'" class=\"btn btn-info details-button\"> <i class=\"fa fa-download\" aria-hidden=\"true\"> </i> download... </a>';
                                }
                            },
                        ],
                        order: [[ 0, 'asc' ]],
                        responsive  : true,
                        fixedHeader: true,
                        processing  : true,
                        pageLength  : 10
                    });

                    // The First Column Autoincrement 
                    table.on( 'order.dt search.dt', function () {
                        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                            cell.innerHTML = i+1;
                        } );
                    } ).draw();

                },
                complete: function(){
                    $('#example').fadeIn();
                },
                error: function(e) {
                    console.log(e)
                }
                
            });
            // End AJAX

            // Go to #myDiv smoothly after click
            $('html, body').animate({
                scrollTop: $("#myDiv").offset().top
            }, 1000);

        })


    </script>

@endsection