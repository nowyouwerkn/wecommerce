<aside class="shop-sidebar pr-5">
    <div class="widget">
        <h4 class="widget-title">Categorías</h4>
        <div class="shop-cat-list">
            <ul>
                <li><a href="#">Accesorios</a><span>(6)</span></li>
                <li><a href="#">Zapatos</a><span>(4)</span></li>
                <li><a href="#">Botas</a><span>(2)</span></li>
                <li><a href="#">Camisas</a><span>(6)</span></li>
                <li><a href="#">Lentes de Sol</a><span>(12)</span></li>
                <li><a href="#">Muebles y Hogar</a><span>(7)</span></li>
                <li><a href="#">Piel</a><span>(9)</span></li>
            </ul>
        </div>
    </div>
    <div class="widget">
        <h4 class="widget-title">Filtra por Precio</h4>
        <div class="price_filter">
            <div id="slider-range"></div>
            <div class="price_slider_amount">
                <span>Precio :</span>
                <input type="text" id="amount" name="price" placeholder="Selecciona tu precio" />
            </div>
        </div>
    </div>
    <div class="widget">
        <h4 class="widget-title">Catálogos</h4>
        <div class="sidebar-brand-list">
            <ul>
                <li><a href="#">Nuevos Lanzamientos <i class="fas fa-angle-double-right"></i></a></li>
                <li><a href="#">Hombre <i class="fas fa-angle-double-right"></i></a></li>
                <li><a href="#">Mujer <i class="fas fa-angle-double-right"></i></a></li>
                <li><a href="#">Temporada SS-21 <i class="fas fa-angle-double-right"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="widget has-border">
        <div class="sidebar-product-size mb-30">
            <h4 class="widget-title">Tallas</h4>
            <div class="shop-size-list">
                <ul>
                    <li><a href="#">S</a></li>
                    <li><a href="#">M</a></li>
                    <li><a href="#">L</a></li>
                    <li><a href="#">XL</a></li>
                    <li><a href="#">XXL</a></li>
                </ul>
            </div>
        </div>
        <div class="sidebar-product-color">
            <h4 class="widget-title">Colores</h4>
            <div class="shop-color-list">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="widget">
        <h4 class="widget-title">Populares</h4>
        <div class="sidebar-product-list">
            <ul>
                @foreach($popular_products as $product)
                <li>
                    <div class="sidebar-product-thumb">
                    <a href="{{ route('detail', [$product->category->slug, $product->slug]) }}"><img src="{{ asset('img/products/' . $product->image) }}" alt=""></a>
                    </div>
                    <div class="sidebar-product-content">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h5><a href="#">{{ $product->name }}</a></h5>
                        <span>$ {{ number_format($product->price, 2) }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</aside>