<div class="row w-100">
    @forelse ($results as $product_info)
    <div class="col-md-4 col-12">
        @include('front.theme.werkn-backbone-bootstrap.layouts.utilities._product_card')
    </div>
    @empty
    <p data-id="0" class="mt-3 mb-3 text-center">Lo sentimos, no hay productos que coincidan con: "{{ $search }}"</p>
    @endforelse
</div>
