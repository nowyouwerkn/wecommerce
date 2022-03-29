@if(!empty($shipment_options))
<div class="shipping-options row">
    @foreach($shipment_options as $options)
        <div class="col-6 mb-3">
            <a href="javascript:void(0)" data-value="{{ $options->id }}" price-value="{{ $options->price }}" id="option{{ $options->id }}" class="card card-body shipping-card">
                <div class="row align-items-between">
                    <div class="col-5 text-center"> 
                        <h4 class="shipping-icon">
                        <ion-icon name="car-sport-outline"></ion-icon>
                        </h4>
                    </div>

                    <div class="col-7"> 
                        <label class="title-shipping">{{ $options->name }}</label>
                        <p class="mb-1" class="delivery-time">{{ $options->delivery_time }}</p>
                        @if($options->price != 0)
                            <h6 class="price">${{ $options->price }}</h6>
                        @else
                            <h6 class=" price price-free">GRATIS</h6>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endif
