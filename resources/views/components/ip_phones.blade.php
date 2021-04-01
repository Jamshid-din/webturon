@extends('home')
@section('content')

    <!--FAQS AREA-->
    
    <section class="faqs-area section-padding wow fadeIn" id="myDiv">
        <div class="container-fluid bb">
            <div class="row col-lg-36">
                <div class="col-lg-8">
                    <div class="faqs-left-img">
                        <table id="example" class="display" style="width:100%; border: 1px; border-color: aqua;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Филиал</th>
                                    <th>Департамент</th>
                                    <th>Ф.И.О.</th>
                                    <th>IP</th>
                                    <th>Должность</th>
                                    <th>Sort</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th><input type="text" placeholder="Поиск Филиал" /></th>
                                    <th><input type="text" placeholder="Поиск Департамент" /></th>
                                    <th><input type="text" placeholder="Поиск Ф.И.О." /></th>
                                    <th><input type="text" placeholder="Поиск IP" /></th>
                                    <th><input type="text" placeholder="Поиск Должность" /></th>
                                    <th>asdf</th>
                                </tr>
                            </thead>
                            
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Филиал</th>
                                    <th>Департамент</th>
                                    <th>Ф.И.О.</th>
                                    <th>IP</th>
                                    <th>Должность</th>
                                    <th>Sort</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Right Side Menu Depart List -->
                <div class="col-lg-4">
                    <div class="faqs-list">
                        <h3 class="get-sub-dep" data-id="1"><a href="#idTable">Все Филиалы</a> </h3>
                        <div class="panel-group" id="accordion">
                            @foreach($depart_list as $key => $dep)
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#faqs_{{$key}}" data-parent="#accordion">
                                                <i class="fa fa-minus"></i> {{ $dep->title_uz }}
                                            </span>
                                        </h4>
                                    </div>
                                    <div id="faqs_{{$key}}" class="panel-collapse collapse">
                                        @foreach($sub_depart_list as $k => $sub_dep)
                                            @if($dep->id === $sub_dep->depart_id)
                                                
                                                <p>
                                                    <i class="fa fa-bars"></i>
                                                    <a href="#" class="get-sub-dep" data-id="{{ $sub_dep->id }}">  {{ $sub_dep->title_uz }}</a>
                                                </p>
                                                
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
                <!-- END Depart List  -->

            </div>            
        </div>


    </section>
    <!--FAQS AREA END-->

    <script src="{{ asset ("js/vendor/jquery-1.12.4.min.js") }}"></script>

    <script type="text/javascript">
        // Default
        $(document).ready(function() {

            // Define Token
            let _token = $('meta[name="csrf-token"]').attr('content');

            // To store response data from ajax
            let res;

            $.ajax({
                url: "/ip_phones/fetch_data",
                type: "GET",
                data: { id: 0 }, // Default table data
                success: function(data){

                    // res variable defined in ready function
                    res = data.msg;

                    // Fill Datatable with default values
                    let table = $('#example').DataTable( {
                        destroy: true,
                        proccessing: true,
                        data: res,
                        columnDefs: [
                            {   className: "ip", 
                                "targets": [ -3 ] 
                            },
                            { 
                                "targets": [ 6 ],
                                "visible": false 
                            },
                        ],
                        columns : [
                            { data: "id" },
                            { data: "dep_title_uz"},
                            { data: "sub_title_uz"},
                            { data: "fio"},
                            { data: "ip"},
                            { data: "descr"},
                            { data: "sort"},
                        ],
                        order: [[ 6, 'asc' ]],
                        responsive  : true,
                        fixedColumns:   true,
                        orderCellsTop: true,
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

                    // Individual filter default 
                    $('#example thead tr:eq(1) th').each( function (i) {
                
                        $( 'input', this ).on( 'keyup change', function () {
                            if ( table.column(i).search() !== this.value ) {
                                table
                                    .column(i)
                                    .search( this.value )
                                    .draw();
                            }
                        } );

                    });

                }
                // End Success

                
            });
            // End AJAX

        });
        // End
        
        // When Department is choosen from right menu of the departments
        $(".get-sub-dep").click(function(){

            // Get sub depart id to send request when department is clicked
            let dep_id = $(this).attr("data-id");

            $.ajax({
                url: "/ip_phones/fetch_data",
                type: "GET",
                data: { id: dep_id }, 
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
                            {   className: "ip", 
                                "targets": [ -3 ] 
                            },
                            { 
                                "targets": [ 6 ],
                                "visible": false 
                            },
                        ],
                        columns : [
                            { data: "id" },
                            { data: "dep_title_uz"},
                            { data: "sub_title_uz"},
                            { data: "fio"},
                            { data: "ip"},
                            { data: "descr"},
                            { data: "sort"},
                        ],
                        order: [[ 6, 'asc' ]],
                        responsive  : true,
                        orderCellsTop: true,
                        fixedHeader: {
                            header: true,
                            footer: true
                        },
                        processing  : true,
                        pageLength  : 10
                    });

                    // The First Column Autoincrement 
                    table.on( 'order.dt search.dt', function () {
                        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                            cell.innerHTML = i+1;
                        } );
                    } ).draw();

                    // Individual filter new
                    $('#example thead tr:eq(1) th').each( function (i) {
                
                        $( 'input', this ).on( 'keyup change', function () {
                            if ( table.column(i).search() !== this.value ) {
                                table
                                    .column(i)
                                    .search( this.value )
                                    .draw();
                            }
                        } );

                    });

                },
                complete: function(){
                    $('#example').fadeIn();
                }
                // End Success
   
            });
            // End AJAX

            // Go to #myDiv smoothly after click
            $('html, body').animate({
                scrollTop: $("#myDiv").offset().top
            }, 1000);

        });
        // End 

    </script>

@endsection