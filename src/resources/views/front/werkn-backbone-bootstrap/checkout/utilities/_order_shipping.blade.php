@if(!empty($shipment_options))
<div class="shipping-options row">
    @foreach($shipment_options as $option)
        <div class="col-6 mb-3">
            <a href="javascript:void(0)" data-value="{{ $option->id }}" data-type="{{ $option->type }}" price-value="{{ $option->price }}" id="option{{ $option->id }}" class="card card-body shipping-card h-100">
                <div class="d-flex align-items-center">
                    <div class="shipping-icon">
                        @if($option->icon != NULL)
                        <img src="{{ asset('img/' . $option->icon) }}" alt="{{ Str::slug($option->name) }}" width="40">
                        @else
                        <img src="{{ asset('assets/img/package.png') }}" alt="{{ Str::slug($option->name) }}" width="40">
                        @endif
                    </div>

                    <div class="shipping-info"> 
                        <label class="title-shipping">{{ $option->name }}</label>
                        <p class="mb-1" class="delivery-time">{{ $option->delivery_time }}</p>

                        @if($option->price != 0)
                            <h6 class="price">${{ $option->price }}</h6>
                        @else
                            <h6 class=" price price-free">GRATIS</h6>
                        @endif

                        @if($option->location != null)
                        <small class="text-muted">{{ $option->location }}</small>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endif