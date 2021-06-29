@extends('home')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset ("style.css") }}">
    <link rel="stylesheet" href="{{ asset ("css/owl.carousel.css") }}">

1   <!--SERVICE AREA-->

    
    <section class="service-area">
        <div class="service-top-area padding-top">
            <div class="container">
                
                <div class="area-title text-center wow fadeIn">
                    <h2>Сервисы</h2>                          
                </div>
                                
            </div>
        </div>       
        <div class="service-bottom-area section-padding" style="background: url({{ asset ("images/4_chi.jpg") }}) no-repeat fixed left;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-md-offset-6 col-lg-offset-6 col-sm-12 col-xs-12">
                        <div class="service-list wow fadeIn">
                            <div class="single-service">
                                <div class="service-icon-hexagon">
                                    <div class="hex">
                                        <div class="service-icon"><i class="fa fa-building"></i></div>
                                    </div>
                                </div>
                                <div class="service-details">
                                    <h4>Департаменты</h4>
                                    <p>Все департаменты банка</p>
                                    <a href="index-3.html">перейти</a>
                                </div>
                            </div>
                            <div class="single-service">
                                <div class="service-icon-hexagon">
                                    <div class="hex">
                                        <div class="service-icon"><i class="fa fa-rss-square"></i></div>
                                    </div>
                                </div>
                                <div class="service-details">
                                    <h4>новости</h4>
                                    <p>Новости Банка</p>
                                    <a href="index-5.html">читать</a>
                                </div>
                            </div>
                            <div class="single-service">
                                <div class="service-icon-hexagon">
                                    <div class="hex">
                                        <div class="service-icon"><i class="fa fa-globe"></i></div>
                                    </div>
                                </div>
                                <div class="service-details">
                                    <h4>EDO</h4>
                                    <p>Turon EDO</p>
                                    <a href="http://edo.turonbank.uz/">перейти</a>
                                </div>
                            </div>
                            <div class="single-service">
                                <div class="service-icon-hexagon">
                                    <div class="hex">
                                        <div class="service-icon"><i class="fa fa-tasks"></i></div>
                                    </div>
                                </div>
                                <div class="service-details">
                                    <h4>Программы</h4>
                                    <p>Программы для ПК</p>
                                    <a href="{{ url('/soft') }}">перейти</a>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   

    <!--SERVICE AREA END-->
 
    <!-- <section class="testmonial-area section-padding" style="background: url(images/fon.jpg) no-repeat scroll center center / cover">
        <div class="container">
            <div class="area-title text-center wow fadeIn">
                <h2>дни рождения сотрудников</h2>
            </div>

   
            <div class="welcome-slider-area" style="left: 350px">
                <div class="welcome-single-slide">
                    <div class="container" style="background-color: white">
                        <div class="row" style="width: 400px; height: 400px; background: white, no-repeat scroll center center / cover">                         
                            <img class="" src="images/rahbar.jpg"/>                  
                        </div>
                        <div class="carousel-caption" style="margin-left: 300px; margin-top: 200px">
                            <h3 style="color: red">C днем рождения Палончи!</h5>
                            <h3>Таваллуд кунингиз блан табриклаймиз!</h5>
                            
                        </div>
                    </div>
                </div>
                <div class="welcome-single-slide">
                    <div class="container" style="background-color: white">
                        <div class="row" style="width: 400px; height: 400px; background: no-repeat scroll center center / cover">                     
                            <img class="" src="images/rahbarzam1.jpg"/>                   
                        </div>
                        <div class="carousel-caption" style="margin-left: 300px">
                            <h3 style="color: red">C днем рождения Палончиев!</h5>
                            <h3>Таваллуд кунингиз блан табриклаймиз!</h5>
                        
                        </div>
                    </div>
                </div>
                <div class="welcome-single-slide">
                    <div class="container" style="background-color: white">
                        <div class="row" style="width: 400px; height: 400px; background: no-repeat scroll center center / cover">                  
                            <img class="" src="images/rahbarzam2.jpg" />   
                        </div>
                        <div class="carousel-caption" style="margin-left: 300px">
                            <h3 style="color: red">C днем рождения Палончиевич!</h5>
                            <h3>Таваллуд кунингиз блан табриклаймиз!</h5>
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->


    <!--TESTMONIAL AREA -->
  
        <section class="testmonial-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3 col-sm-12 col-xs-12">
                        <div class="area-title text-center wow fadeIn">
                            <h2>правление банка</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                        <div class="client-photo-list wow fadeIn">
                            <div class="client_photo">
                                <div class="item">
                                    <img src="{{ asset ("images/rahbar.jpg") }}" alt="">
                                </div>
                                <div class="item">
                                    <img src="{{ asset ("images/rahbarzam1.jpg") }}" alt="">
                                </div>
                                <div class="item">
                                    <img src="{{ asset ("images/rahbarzam3.jpg") }}" alt="">
                                </div>
                                <div class="item">
                                    <img src="{{ asset ("images/rahbarzam2.jpg") }}" alt="">
                                </div>
                                <div class="item">
                                    <img src="{{ asset ("images/rahbarzam4.jpg") }}" alt="">
                                </div>
                                <div class="item">
                                    <img src="{{ asset ("images/rahbarzam5.jpg") }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="client_nav">
                            <span class="fa fa-angle-left testi_prev"></span>
                            <span class="fa fa-angle-right testi_next"></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-10 col-md-offset-1 text-center">
                        <div class="client-details-content wow fadeIn">
                            <div class="client_details">
                                <div class="item">
                                    
                                    <h3>Мирзаев Чори Садибакосович</h3>
                                    <p>Председатель правления</p>
                                    <br>
                                    <p>Телефон: +998 95 144-60-00</p> 
                                    <p>Факс: +998 71 244-32-32</p>                               
                                    
                                </div>
                                <div class="item">
                                    
                                    <h3>Ташаев Азиз Тахирович</h3>
                                    <p>Первый Заместитель Председателя Правления</p>
                                    <br>
                                    <p>Телефон: +998 95 144-60-00</p> 
                                    <p>Факс: +998 71 244-32-32</p>
                                </div>
                                <div class="item">
                                    
                                    <h3>Калдыбаев Султан Торабекович</h3>
                                    <p>Заместитель Председателя Правления</p>
                                    <br>
                                    <p>Телефон: +998 95 144-60-00</p> 
                                    <p>Факс: +998 71 244-32-32</p>
                                </div>
                                <div class="item">
                                    
                                    <h3>Рустамов Дилшод Абдухаписович</h3>
                                    <p>Вр.и.о. Заместителя Председателя Правления</p>
                                    <p>Директор Департамента Казначейство и Ценных бумаг</p>
                                    <br>
                                    <p>Телефон: +998 95 144-60-00</p> 
                                    <p>Факс: +998 71 244-32-32</p>
                                </div>
                                <div class="item">
                                    
                                    <h3>Бозоров Шерзод Эшманавич</h3>
                                    <p>Директор Департамента Бухгалтерского учёта и Финансовой отчётности</p>
                                    <br>
                                    <p>Телефон: +998 95 144-60-00</p> 
                                    <p>Факс: +998 71 244-32-32</p>
                                </div>
                                <div class="item">
                                    
                                    <h3>Арипов Бекзод Нафасович</h3>
                                    <p>Директор Департамента Юридической службы</p>
                                    <br>
                                    <p>Телефон: +998 95 144-60-00</p> 
                                    <p>Факс: +998 71 244-32-32</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="testmonial-area section-padding" style="background-color: #F2F3F4">
            <div class="area-title text-center wow fadeIn">
                <h2>Анонимные предложения сотрудников банка</h2>                          
            </div>
            <div class="container">
                <form id="anonymForm" method="POST" action="{{ route('store-message') }}">
                    @csrf
                    <div class="row">
                        <div class="col-25">
                        <label for="message_title">Выберите раздел</label>
                        </div>
                        <div class="col-75">
                        <input type="text" name="title" id="message_title" maxlength="150" placeholder="Заглавие..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                        <label for="message_text">Предложения по банку</label>
                        </div>
                        <div class="col-75">
                        <textarea id="message_text" name="text" placeholder="Напишите что-нибудь..." style="height:200px" maxlength="400" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" class="btn btn-primary" value="Отправить">
                    </div>
                </form>
            </div>
        </section>


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
            <button id="closeModal" type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
        </div>
    </div>

    <!--TESTMONIAL AREA END -->
    <!--====== SCRIPTS JS ======-->
    <script src="{{ asset ("js/jquery.min.js") }}"></script>

    <script src="{{ asset ("js/vendor/jquery-1.12.4.min.js") }}"></script>
    <script src="{{ asset ("js/owl.carousel.min.js") }}"></script>
    


    <script type="text/javascript">
        $("#anonymForm").submit(function(e){
            e.preventDefault()
            $.ajax({
                type : 'POST',
                data: $("#anonymForm").serialize(),
                url : '/home-store',
                success : function(data){
                    console.log(data)
                    $('#delete').modal('toggle')
                    $('#responseModal .modal-title').text('Success')
                    $('#responseModal .modal-footer button').removeClass('btn-danger').addClass('btn-success')
                    $('#responseModal').modal('toggle')
                    $('#responseModal .modal-body p').text("Успешно отправлено")
                    $("#responseModal").modal("show")
                    
                    $('#closeModal').click(function() {
                        location.reload();
                    })


                }
            });
            return false;
        });
    </script>
@endsection