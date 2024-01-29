<x-main>
        
  <div class="row mb-3 mt-3">
    @if($ad_to_check)
      <div class="text-primary d-flex align-items-center justify-content-center gap-2">
        <h4>{{__('ui.revisor_ads')}}</h4>
        <i class="fa-solid fa-mug-hot"></i>
      </div>
      @else
      <div class="text-primary d-flex align-items-center justify-content-center gap-2">
        <h4>{{__('ui.revisor_no_ads')}}</h4>
        <i class="fa-solid fa-umbrella-beach"></i>
      </div>
    @endif
  </div>
        
  @if($ad_to_check)
      
    <div class="row">
      @if($ad_to_check->images->count() > 0)
      {{-- carosello --}}
      <div class="col-12 col-md-4">
        <div id="carouselExampleIndicators" class="carousel slide">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner">
            @foreach ($ad_to_check->images as $img)
              <div class="carousel-item @if($loop->first) active @endif">
                
                <img src="{{$img->getUrl(600,600)}}" class="d-block w-100" alt="...">
                
              
                
              </div>
              @endforeach
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      {{-- fine carosello --}}
      @else
      <p class="fst-italic">Questo annuncio non ha foto.</p>
      @endif
      {{-- inizio dati + azioni --}}
      <div class="col-12 col-md-8 p-2">
        <p><strong>{{__('ui.title')}}:</strong> {{$ad_to_check->title}}</p>
        <p><strong>{{__('ui.price')}}:</strong> € {{number_format($ad_to_check->price, 2, ',', '.')}}</p>
        <p><strong>{{__('ui.category')}}:</strong> {{$ad_to_check->category->name}}</p>
        <p><strong>{{__('ui.description')}}:</strong> {{$ad_to_check->description}}</p>
        <p><strong>{{__('ui.seller')}}:</strong> {{$ad_to_check->user->name}}</p>
        <p><strong>{{__('ui.date')}}:</strong> {{$ad_to_check->created_at->format('d/m/y')}}</p>
        <div class="d-flex gap-2 mt-5">
          <form action="{{route('revisor.accept_ad',['ad'=>$ad_to_check])}}" method="POST">
            @csrf
            @method('PATCH') 
            <button type="submit" class="btn btn-outline-primary">{{__('ui.accept')}}</button>
          </form>
          <form action="{{route('revisor.reject_ad',['ad'=>$ad_to_check])}}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-outline-danger">{{__('ui.reject')}}</button>
          </form>
        </div>
      </div>
      {{-- fine dati + azioni --}}
    </div>            

  @endif

  <div class="row mt-5 history-section">
    <div class="d-flex justify-content-between mt-4">
      <h2 class="text-center">{{__('ui.history')}}</h2>
    </div>

    <div class="col-12 col-md-6 table-responsive">
      <h5 class="text-danger my-3">{{__('ui.rejected_ads')}}</h5>
      <table class="table table-striped small">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('ui.title')}}</th>
            <th scope="col">{{__('ui.category')}}</th>
            
            <th scope="col">{{__('ui.price')}}</th>
            <th scope="col">{{__('ui.seller')}}</th>
            
            <th scope="col">{{__('ui.actions')}}</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($rejected_ads as $rejected_ad)
                <tr>
                    <th scope="row">{{$rejected_ad->id}}</th>
                    <td>{{$rejected_ad->title}}</td>
                    <td>
                      @if (app()->getLocale() == 'it')
                      {{ $rejected_ad->category->title_it }}
                      @elseif (app()->getLocale() == 'en')
                        {{ $rejected_ad->category->title_en }}
                      @elseif (app()->getLocale() == 'es')
                        {{ $rejected_ad->category->title_es }}
                      @else
                        {{ $rejected_ad->category->title_en }} 
                      @endif
                    </td>
                    
                    <td>€ {{number_format($rejected_ad->price, 2, ',', '.')}}</td>
                    <td>{{$rejected_ad->user->name}}</td>
                    
                    <td>
                        
                      <a class="btn btn-outline-success" href="{{route('revisor.restore', $rejected_ad)}}">{{__('ui.restore')}}</a>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
      {{ $rejected_ads->links() }}
    </div>

    <div class="col-12 col-md-6 table-responsive">
      <h5 class="text-primary my-3">{{__('ui.accepted_ads')}}</h5>
      <table class="table table-striped small">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('ui.title')}}</th>
            <th scope="col">{{__('ui.category')}}</th>            
            <th scope="col">{{__('ui.price')}}</th>
            <th scope="col">{{__('ui.seller')}}</th>            
            <th scope="col">{{__('ui.actions')}}</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($accepted_ads as $accepted_ad)
                <tr>
                    <th scope="row">{{$accepted_ad->id}}</th>
                    <td>{{$accepted_ad->title}}</td>
                    <td>
                      @if (app()->getLocale() == 'it')
                          {{ $accepted_ad->category->title_it }}
                          @elseif (app()->getLocale() == 'en')
                            {{ $accepted_ad->category->title_en }}
                          @elseif (app()->getLocale() == 'es')
                            {{ $accepted_ad->category->title_es }}
                          @else
                            {{ $accepted_ad->category->title_en }} 
                          @endif
                    </td>                    
                    <td>€ {{number_format($accepted_ad->price, 2, ',', '.')}}</td>
                    <td>{{$accepted_ad->user->name}}</td>                    
                    <td>
                      <a class="btn btn-outline-danger" href="{{route('revisor.back', $accepted_ad)}}">{{__('ui.revoke')}}</a>                        
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
    {{ $accepted_ads->links() }}
    </div>

  </div>
</x-main>
        
