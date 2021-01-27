@extends('home')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset ("style.css") }}">

  <section id="postsSection" class="faqs-area section-padding wow fadeIn">
    
      <div class="container ">
        @foreach($models->chunk(3) as $posts)
        <div class="row">
          @foreach($posts as $key => $model)
            <div class="card col-md-4">
              <img src="{{ asset('storage/media/'.$model->media->hash??'') }}" class="img-thumbnail rounded" alt="..." style="background-size: cover; height: 200px;">
              <div class="card-body">
                <p class="card-text"><h5>{{ $model->title }}</h5></p>
                <p class="card-text card-click"><h6><a href="#singlePostSection" data-id="{{ $model->id }}" class="card-click">подробнее</a></h6></p>
              </div>
            </div>
            @endforeach
          </div>
        @endforeach
      </div>

  </section>

  
  <section id="singlePostSection" class="faqs-area section-padding fadeIn" hidden>
    

    <div class="container">
      <div class="row">
        <div class="col-md-1 text-center">
          <a id="backLink" href="#postsSection"><i class="fa fa-angle-double-left fa-4x"></i></a>
        </div>
      </div>
        <div class="col-md-6 p-3 m-3">
          <img id="singlePostImg" src="images/news4.jpg" class="rounded img-thumbnail float-left" alt="...">
        </div>
        <h3 id="singlePostTitle"></h3>
        <b><p id="singlePostCreatedAt">  </p></b>
        <div class="card-body">
          <p id="singlePostText" class="card-text" style="font-size: 16px"></p>
        </div>
      

    </div>

  </section>
  <!--FAQS AREA END-->

  <!--   Core JS Files   -->
  <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
  
  <script>
    $(document).ready(function(){
      // Token
      let csrf_token = $('meta[name="csrf-token"]').attr('content')

      $('.card-click').click(function(){
        $('#postsSection').slideToggle('slow')

        let id = $(this).data('id')

        $.ajax({
          url: '/news-fetch-post/' + id,
          data: {
            _token: csrf_token,
            id    : id
          },
          type: 'get',
          success: function(result){
            let model = result['model']
            let file = result['file']

            $('#singlePostTitle').text(model.title)
            $('#singlePostText').text(model.text)
            $('#singlePostCreatedAt').text(model.created_at)
            $("#singlePostImg").attr("src","{{ asset('storage/media') }}/"+file.hash);
            $('#singlePostSection').slideToggle("slow");

          },
          error: function(error){
            console.log(error)
          }

        })


      })

      $('#backLink').click(function(){
        $('#singlePostSection').slideToggle("slow");
        $('#postsSection').slideToggle('slow')
      })

    })  
  </script>

@endsection