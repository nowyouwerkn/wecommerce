<div class="we-co--header container">
	<div class="row align-items-center">
		<div class="col-12 show-hidden text-center">
			<p class="mb-2 mt-4"><ion-icon name="lock-closed"></ion-icon> Compra Segura</p>
		</div>

		<div class="col-12 col-md-4">
			<div class="d-flex align-items-center">
				@if(!empty($store_config))
	                @if($store_config->store_logo == NULL)
	                <img src="{{ asset('assets/img/logo.png') }}" class="we-co--logo" alt="Logo">
	                @else
	                <img src="{{ asset('assets/img/' . $store_config->store_logo) }}" class="we-co--logo" alt="Logo">
	                @endif
	            @else
	            	<img src="{{ asset('assets/img/logo.png') }}" class="we-co--logo" alt="Logo">
	            @endif

	            <a href="{{ route('catalog.all') }}" class="we-co--return-btn"><ion-icon name="return-down-back"></ion-icon> Volver a la tienda</a>
			</div>
		</div>

		<div class="col-4 res-hidden">
			<div class="text-center">
				<h2 class="mb-0">Checkout</h2>
			</div>
		</div>

		<div class="col-4 d-flex justify-content-end res-hidden">
			<div class="we-co--trust-logo">
				<div class="d-flex align-items-center">
					<script type="text/javascript"> //<![CDATA[
		              var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
		              document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
		            //]]></script>
		            <script language="JavaScript" type="text/javascript">
		              TrustLogo("https://www.positivessl.com/images/seals/positivessl_trust_seal_md_167x42.png", "POSDV", "none");
		            </script>

		            <div class="we-co--trust-logo-info">
		            	<h5>Compra Segura</h5>
		            	<p>Sitio Seguro con Encriptación de 256-Bits</p>
		            </div>
				</div>
	        </div>
		</div>

		<div class="col-12">
			<hr>
		</div>
	</div>
</div>

{{-- 
<div class="we-co--header-responsive container">
	<div class="row align-items-center">
		<div class="col-12" style="text-align: center; margin-top: 20px;">
			<div class="align-items-center">
				@if(!empty($store_config))
	                @if($store_config->store_logo == NULL)
	                <img src="{{ asset('assets/img/logo.png') }}" class="we-co--logo" alt="Logo">
	                @else
	                <img src="{{ asset('assets/img/' . $store_config->store_logo) }}" class="we-co--logo" alt="Logo">
	                @endif
	            @else
	            <img src="{{ asset('assets/img/logo.png') }}" class="we-co--logo" alt="Logo">
	            @endif
			</div>
		</div>

		<div class="col-6">
			<div class="text-center">
				<h2 class="mb-0">Checkout</h2>
			</div>
		</div>

		<div class="col-6 d-flex justify-content-end">
			<div class="we-co--trust-logo">
				<div class="d-flex align-items-center">

		            <div class="we-co--trust-logo-info">
		            	<h5>Compra Segura</h5>
		            	<p>Sitio Seguro con Encriptación de 256-Bits</p>
		            </div>
				</div>
	        </div>
		</div>

		<div class="col-12">
			     <a href="{{ route('catalog.all') }}" class="we-co--return-btn-responsive"><ion-icon name="return-down-back"></ion-icon> Volver a la tienda</a>
			<hr>
		</div>
	</div>
</div>
--}}