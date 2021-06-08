@extends('home')
@section('content')

    <!--FAQS AREA-->
    
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
                                    <th style="width: 20%;">Подробно</th>                                   
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
                
                <!-- Sider Menu Archive -->
                <div class="col-lg-4">
                    <h3>Фильтр</h3>

                        <ul id="tree1">
                            @foreach($menu as $value)
                                <li style="font-weight: bold; font-size: 16px; margin:10px; padding 5px; cursor: pointer;" >
                                    {{ $value->title_uz }}
                                    @if(count($value->childs))
                                        @include('components.ajax',['childs' => $value->childs])
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                </div>
                <!-- Menu END -->

            </div>
        </div>
    </section>
    <!--FAQS AREA END-->
    
    <script src="{{ asset ("js/vendor/jquery-1.12.4.min.js") }}"></script>
    <script src="{{ asset('js/treeview.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function() {

            // Define Token
            let _token = $('meta[name="csrf-token"]').attr('content');

            // To store response data from ajax
            let res;

            let id = $('.get-sub').data('id')

            $.ajax({
                url: "/staff/fetch_data",
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
                                defaultContent: "<button class=\"btn btn-info\"> Детали...<i class=\"fa fa-info\" aria-hidden=\"true\"> </i></button>"
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

                    // On click button on the table
                    $('#example tbody').on( 'click', 'button', function () {
                        let data1 = table.row( $(this).parents('tr') ).data();

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


        });

        // When Department is choosen from right menu of the departments
        $(".post_users").click(function(){

            // Get sub depart id to send request when department is clicked
            let dep_id = $(this).attr("data-id");

            $.ajax({
                "url": "/staff/fetch_data",
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
                        let data2 = table.row( $(this).parents('tr') ).data();

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
            }, 1000);

        });

        /* Formatting function for row details - modify as you need */
        function format ( d ) {

            let download_link = ''
            let download_e_link = ''

            if ( typeof d == 'undefined') {
                return "Empty"
            }
            if(d.doc_file_id)   download_link   = '<a href="{{ url("download-personal/")}}/'+d.doc_file_id+'"> <i class="fa fa-download" aria-hidden="true">Скачать</i></a>'
            if(d.doc_e_file_id) download_e_link = '<a href="{{ url("download-personal/")}}/'+d.doc_e_file_id+'"> <i class="fa fa-download" aria-hidden="true">Скачать</i></a>'

            

            // `d` is the original data object for the row
            return '<div class="slider">'+
                '<table cellpadding="" cellspacing="0" border="0" style="padding-left:5px;style="width: 80%;"">'+
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

    </script>

@endsection