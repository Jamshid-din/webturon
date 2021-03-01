<!--START TOP AREA-->

<header class="top-area {{ (Request::path() != '/')?'single-page':'' }}" id="home">
    @switch(Request::path())
        @case('/')
        @case('home')
            @break
        @case('news')
            <div class="top-area-bg-news" data-stellar-background-ratio="0.6"></div>
            @break
        @case('docs')
            <div class="top-area-bg-docs" data-stellar-background-ratio="0.6"></div>
            @break
        @case('ip_phones')
            <div class="top-area-bg" data-stellar-background-ratio="0.6"></div>
            @break
        @case('staff')
            <div class="top-area-bg-personal" data-stellar-background-ratio="0.6"></div>
            @break
        @case('soft-guest')
            <div class="top-area-bg-soft" data-stellar-background-ratio="0.6"></div>
            @break
        @default
            <div class="top-area-bg-docs" data-stellar-background-ratio="0.6"></div>
            @break
    @endswitch
    <div class="header-top-area">
        <!--MAINMENU AREA-->
        <div class="mainmenu-area" id="mainmenu-area">
            <div class="mainmenu-area-bg"></div>
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-header">
                        
                        <a href="/" class="navbar-brand"><img src="{{ asset ("images/turon_bank-1024x1024%20(1).png") }}" alt="logo" width="190px"></a>
                    </div>
                    <div class="search-and-language-bar pull-right">
                        <ul>
                            <!-- <li class="select-language"><i class="fa fa-globe"></i> </li> -->
                            <li class="select-language"><a href="#" value="RU">РУ</a></li>
                            <li class="select-language">  <a href="#" value="UZ">УЗ</a></li>
                            <li class="search-box"><i class="fa fa-search"></i></li>

                        </ul>
                        <form action="#" class="search-form">
                            <input type="search" name="search" id="search">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <div id="main-nav" class="stellarnav">
                        <ul id="nav" class="nav navbar-nav">
                            <li><a href="/news-guest">Новости </a></li>
                            <li><a href="/docs">Документы</a>                                  
                            </li>
                            <li><a href="/ip_phones">IP Телефон</a>
                            </li>
                            <li><a href="/staff">Персонал</a>                                   
                            </li>
                            <li><a href="/soft-guest">Программы</a>                                   
                            </li>
                            <li><a href="">Web Turon</a>
                                <ul>
                                    <li><a class="mainT" href="" target="_blank">Banking</a></li>
                                    <li><a class="mainT" href="" target="_blank">Cabinet</a></li>
                                    <li>
                                        <a class="mainT" href="http://test.turonbank.uz" target="_blank">Тестинг</a>
                                    </li>
                                    <li><a class="mainT" href="http://edo.turonbank.uz" target="_blank">EDO</a></li>
                                    <li><a class="mainT" href="http://bi.turonbank.uz/" target="_blank">Metabase</a></li>
                                    <li><a class="mainT" href="https://mail.turonbank.uz/" target="_blank">Почта</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!--END MAINMENU AREA END-->
    </div>

    <!--HOME SLIDER AREA-->

    @if((Request::path() === '/') || (Request::path() === '/home'))
    <!--HOME SLIDER AREA-->
        <div class="welcome-slider-area">
            @switch($models->count())
                @case(0)
                    <div class="welcome-single-slide slider-bg-one">
                        <div class="container">
                            <div class="row flex-v-center">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="welcome-text text-center">
                                        <h1>WebTuron</h1>
                                        
                                        <div class="home-button">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="welcome-single-slide slider-bg-one">
                        <div class="container">
                            <div class="row flex-v-center">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="welcome-text text-center">
                                        <h1>WebTuron</h1>
                                        
                                        <div class="home-button">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @break

                @case (1)
                    @for ($i = 0; $i < 2; $i++)
                        @php("Holaa")
                        @foreach($models as $key => $model)
                        <div class="welcome-single-slide slider-bg-one" style="background:url('{{ '/storage/media/'.$model->media->hash??'' }}') no-repeat scroll center center / cover">
                            <div class="container">
                                <div class="row flex-v-center">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="welcome-text text-center">
                                            <h1>{{ $model->title}}      </h1>
                                            
                                            <div class="home-button">
                                                <a href="{{ url('/news-guest')}}">ПОДРОБНЕЕ </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endfor
                @break

                @default
                    @foreach($models as $key => $model)
                    <div class="welcome-single-slide slider-bg-one" style="background:url('{{ '/storage/media/'.$model->media->hash??'' }}') no-repeat scroll center center / cover">
                        <div class="container">
                            <div class="row flex-v-center">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="welcome-text text-center">
                                        <h1>{{ $model->title}}</h1>
                                        
                                        <div class="home-button">
                                            <a href="{{ url('/news-guest')}}">ПОДРОБНЕЕ</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @break
            @endswitch    
        </div>
    <!--END HOME SLIDER AREA-->
    @else
    <div class="welcome-area">
        <div class="area-bg"></div>
            <div class="container">
                <div class="row flex-v-center">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="welcome-text text-center">
                            @switch (true)
                            
                                @case (strpos(Request::path(), 'news') !== false)
                                    <h2>Новости</h2>
                                    <ul class="page-location">
                                        <li><a href="/">Главная</a></li>
                                        <li>/</li>
                                        <li><a href="/news-guest">Новости</a></li>
                                    </ul>
                                    @break

                                @case (strpos(Request::path(), 'docs') !== false)
                                    <h2>Документы</h2>
                                    <ul class="page-location">
                                        <li><a href="/">Главная</a></li>
                                        <li>/</li>
                                        <li><a href="/docs">Документы</a></li>
                                    </ul>
                                    @break
                                @case (strpos(Request::path(), 'ip_phones') !== false)
                                    <h2>IP телефоны</h2>
                                    <ul class="page-location">
                                        <li><a href="/">Главная</a></li>
                                        <li>/</li>
                                        <li><a href="/ip_phones">IP Телефоны</a></li>
                                    </ul>
                                    @break
                                @case (strpos(Request::path(), 'staff') !== false)
                                    <h2>Персонал</h2>
                                    <ul class="page-location">
                                        <li><a href="/">Главная</a></li>
                                        <li>/</li>
                                        <li><a href="/staff">Персонал</a></li>
                                    </ul>
                                    @break
                                @case (strpos(Request::path(), 'soft-guest') !== false)
                                    <h2>Программы</h2>
                                    <ul class="page-location">
                                        <li><a href="/">Главная</a></li>
                                        <li>/</li>
                                        <li><a href="/soft-guest">Программы</a></li>
                                    </ul>
                                    @break
                                @default
                                    @break

                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</header>
<!--END TOP AREA-->