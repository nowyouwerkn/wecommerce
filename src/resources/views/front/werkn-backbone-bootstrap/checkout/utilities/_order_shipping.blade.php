     <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <div class="shipping-options row">
        @foreach($shipment_options as $options)
            <div class="col-md-4 col-12 mt-1">
                 
                    <a href="javascript:void(0)" data-value="{{ $options->id }}" price-value="{{ $options->price }}" id="option{{ $options->id }}" class="shipping-card  row align-items-between w-100">
                        <div class="col-5" style="text-align: center;"> 
                            <h4 class="shipping-icon">
                            <i class="fas fa-shipping-fast"></i>
                            </h4>
                        </div>

                        <div class="col-7"> 
                            <h4>
                            {{ $options->name }}
                            </h4>
                            <p class="mb-1">
                            {{ $options->delivery_time }}
                            </p>
                            @if($options->price != 0)
                            <h5 class="price">
                            ${{ $options->price }}
                            </h5>
                            @else
                            <h5 class="price-free" style="color: green;">
                            GRATIS
                            </h5>
                            @endif
                        </div>
                    
                        
                    </h4>
                   
            </a>
             </div>
            @endforeach
    </div>
