<?=
    /* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
    '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>Fuente XML | Catálogo WeCommerce</title>
		<description>Catálogo de Tienda en Línea</description>
		<link>{{ route('index') }}</link>
		<atom:link href="{{ route('xml.feed') }}" rel="self" type="application/rss+xml" />

		@foreach($items as $product)
		<item>
			<g:item_group_id>product_{{ $product->sku }}</g:item_group_id>
			<g:id>{{ $product->id }}</g:id>
			<g:mpn>{{ $product->barcode ?? $product->sku }}</g:mpn>
			<g:title>{{ $product->name }}</g:title>
			<g:description>{{ $product->description }}</g:description>
			@php
				$str = preg_replace('/<[^>]*>/', '', $product->materials);
				$clean_material = Illuminate\Support\Str::limit(Purifier::clean($str), 200);
			@endphp

			<g:material>{{ $clean_material }}</g:material>
			<g:pattern>{{ $product->pattern ?? 'N/A' }}</g:pattern>
			<color>{{ $product->color ?? 'N/A' }}</color>
			<g:category>{{ $product->category->name ?? ''}}</g:category>
			<g:link>{{ route('detail', [$product->category->slug ?? '', $product->slug]) }}</g:link>

			<g:image_link>{{ asset('img/products/' . $product->image) }}</g:image_link>
			
			@foreach($product->images as $image)
			<additional_image_link>{{ asset('img/products/' . $image->image) }}</additional_image_link>
			@endforeach

			<size>
				@if($product->has_variants == true)
					@if(count($product->variants) == 0)
						0
						@foreach($product->variants as $size)
							{{ $size->size }}@if($product->variants->count() >= 2), @endif
						@endforeach
					@endif
				@else
				unique
				@endif
			</size>

			<age_group>{{ $product->age_group ?? 'all ages'}}</age_group>
			<gender>{{ $product->gender ?? 'unisex'}}</gender>
			
			@if($product->brand != NULL)
				<g:brand>{{ $product->brand }}</g:brand>
			@endif

			<g:condition>{{ $product->condition ?? 'New' }}</g:condition>
			
			@php
                $size_total = 0;

	            foreach ($product->variants_stock as $sz) {
	                $size_total += $sz->stock;
	            };

	            $size_total;
            @endphp

			@if($product->status == 'Publicado')
				@if($size_total == 0)
					<g:availability>out of stock</g:availability>
				@else
					<g:availability>in stock</g:availability>
				@endif
				<status>active</status>
			@else
			<status>archived</status>
			<g:availability>out of stock</g:availability>
			@endif
			
			<g:inventory>{{ $size_total }}</g:inventory>

			<g:price>{{ number_format($product->price, 2) }} @if($config->currency_id == 2)MXN @else USD @endif</g:price>
			<g:sale_price>{{ number_format($product->discount_price, 2) }} @if($config->currency_id == 2)MXN @else USD @endif</g:sale_price>

			@if($product->has_discount == true)
			<g:sale_price_effective_date>{{ Carbon\Carbon::parse($product->discount_start)->subDay()->format('Y-m-d') }}T23:59+00:00/{{ Carbon\Carbon::parse($product->discount_end)->format('Y-m-d') }}T23:59+00:00</g:sale_price_effective_date>
			@endif

			<g:product_type>{{ $product->google_product_category ?? 'Apparel & Accessories > Shoes' }}</g:product_type>
			<g:fb_product_category>{{ $product->fb_product_category ?? 'clothing & accessories > shoes & footwear' }}</g:fb_product_category>
			<g:google_product_category>{{ $product->google_product_category ?? 'Apparel & Accessories > Shoes' }}</g:google_product_category>
		</item>
		@endforeach
	</channel>
</rss>