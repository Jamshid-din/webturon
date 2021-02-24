<!--FAQS AREA-->
@extends('home')
@section('content')
    
    <section class="faqs-area section-padding wow fadeIn" id="myDiv">
        <div class="container" style="width: 80%;">
            <div class="row col-lg-12">
                <div class="col-lg-8">
                    <div class="faqs-left-img">

                        <table id="example" class="display">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">#</th>
                                    <th>Название документа</th>
                                    <th style="width: 20%;">Подробно</th>
                                    
                                </tr>
                            </thead>
                            
                            <tfoot>
                                <tr>
                                    <th style="width: 10%;">#</th>
                                    <th>Название документа</th>
                                    <th style="width: 20%;"></th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

                <!-- Sider Menu Archive -->
                <div class="col-lg-4">
                    <div class="faqs-list">
                        <h3>Раздел Документов</h3>
                        <div class="panel-group" id="accordion">
                            
                            @foreach($menu as $key => $value)
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="parentMenu" data-key="{{ $key }}" data-id="{{ $value->id }}" data-toggle="collapse" data-parent="#accordion" href="#faqs_{{$key}}"><i class="fa fa-{{ ($key == 0) ? 'plus':'minus' }}"></i> {{ $value->title_uz }}</a>
                                        </h4>
                                    </div>
                                    <div id="faqs_{{$key}}" class="panel-collapse {{ ($key == 0) ? 'in':'collapse' }}">
                                        
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        
                    </div>
                </div>
                <!-- Menu END -->

            </div>
        </div>
    </section>
    <!--FAQS AREA END-->


    <script src="{{ asset ("js/vendor/jquery-1.12.4.min.js") }}"></script>
    <script type="text/javascript">
        /* Formatting function for row details - modify as you need */
        function format ( d ) {

            let download_link = ''
            let download_e_link = ''

            if ( typeof d == 'undefined') {
                return "Empty"
            }
            if(d.doc_file_id)   download_link   = '<a href="{{ url("download-docs/")}}/'+d.doc_file_id+'"> <i class="fa fa-download" aria-hidden="true">Скачать</i></a>'
            if(d.doc_e_file_id) download_e_link = '<a href="{{ url("download-docs/")}}/'+d.doc_e_file_id+'"> <i class="fa fa-download" aria-hidden="true">Скачать</i></a>'

            // `d` is the original data object for the row
            return '<div class="slider">'+
                '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                    '<tr>'+
                        '<td>Text:</td>'+
                        '<td>'+d.doc_text+'</td>'+
                        '<td></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Scan File:</td>'+
                        '<td>'+ ((d.doc_file_id) ? d.doc_name :'Пусто') +'</td>'+
                        '<td>'+ download_link +'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>E-File:</td>'+
                        '<td>'+((d.doc_e_file_id) ? d.e_doc_name :'Пусто')+'</td>'+
                        '<td>'+ download_e_link +'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Created:</td>'+
                        '<td>'+d.created_at+'</td>'+
                        '<td></td>'+
                    '</tr>'+
                '</table>'+
            '</div>';
        }    
            
        $(document).ready(function() {

            // Define Token
            let _token = $('meta[name="csrf-token"]').attr('content')
            
            // To store response data from ajax
            let res

            let id = $('.get-sub').data('id')

            $.ajax({
                url: "/docs/fetch_data",
                type: "GET",
                data: { id: id }, // Default
                success: function(data){

                    // res variable defined in ready function
                    res = data.msg;

                    // Fill Datatable with default values
                    let table = $('#example').DataTable( {
                        destroy: true,
                        proccessing: true,
                        data: res,
                        columnDefs: [ 
                            {
                                targets: 2,
                                data: null,
                                defaultContent: "<button class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#exampleModal\"> Детали...<i class=\"fa fa-info\" aria-hidden=\"true\"> </i></button>"
                            },
                        ],
                        columns : [
                            { data: "id" },
                            { data: "doc_title"},
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

                    // Add event listener for opening and closing details
                    $('#example tbody').on('click', 'button', function () {
                        var tr = $(this).closest('tr');
                        var row = table.row( tr );
                
                        if ( row.child.isShown() ) {
                            
                            // This row is already open - close it
                            $('div.slider', row.child()).slideUp( function () {
                                row.child.hide();
                                tr.removeClass('shown');
                            } );
                        }
                        else {
                            // Open this row
                            row.child( format(row.data())).show();
                            tr.addClass('shown');
                            
                            $('div.slider', row.child()).fadeTo();
                        }
                    } );


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

        $(".get-sub").click(function(){

            // Get sub depart id to send request when department is clicked
            let dep_id = $(this).attr("data-id");

            $.ajax({
                "url": "/docs/fetch_data",
                'type': "GET",
                'data': { id: dep_id },
                beforeSend: function(){
                    $('#example').fadeOut();
                },
                success: function(data){

                // res variable defined in ready function
                res = data.msg;

                // Fill Datatable with default values
                let table = $('#example').DataTable( {
                    destroy: true,
                    proccessing: true,
                    data: res,
                    columnDefs: [ 
                        {
                            targets: 2,
                            data: null,
                            defaultContent: "<button class=\"btn btn-info details-button\"> Детали...<i class=\"fa fa-info\" aria-hidden=\"true\"> </i></button>"
                        },
                    
                    ],
                    columns : [
                        { data: "id" },
                        { data: "doc_title"},
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

                // On click button on the table for details
                $('.details-button').click('button', function () {
                    let data = table.row( $(this).parents('tr') ).data();

                    var tr = $(this).closest('tr');
                    var row = table.row( tr );
            
                    if ( row.child.isShown() ) {
                        
                        // This row is already open - close it
                        $('div.slider', row.child()).slideUp( function () {
                            row.child.hide();
                            tr.removeClass('shown');
                        } );
                    }
                    else {
                        // Open this row
                        row.child( format(row.data())).show();
                        tr.addClass('shown');
                        
                        $('div.slider', row.child()).fadeTo();
                    }
                });

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
            }, 1500);
            
        });
        
        $(document).on('click', '.parentMenu', function(){
            let id = $(this).data("id");
            let key = $(this).data("key")

            $.ajax({
                "url": "/docs/fetch_child/" + id,
                'type': "GET",
                success: function(data){

                    let sub_menu = data['sub_menu']
                    let newChild = ''

                    $.each(sub_menu, function(index, val){
                        newChild += '<p><i class="fa fa-bars"></i><a href="#" class="parentMenu" data-key="'+index+'" data-id="'+val.id+'">  '+val.title_uz+' </span></p>'
                    })

                    $('#faqs_'+key).append(newChild)    
                    

                },
                complete: function(){
                    $('#example').fadeIn();
                },
                error: function(e) {
                    console.log(e)
                }

            });

        })


    </script>

@endsection