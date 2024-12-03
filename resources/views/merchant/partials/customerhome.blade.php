<!-- resources/views/store/partials/customerhome.blade.php -->
<div class="featured-products mt-4">
    <h3>Featured Products</h3>
    <hr>
    <div class="homeallproduct-products-row d-flex flex-wrap justify-content-start">
        @foreach ($featuredProducts as $product)
            <a href="{{ route('product.view', $product->product_id) }}" class="product-link">
                <div class="product-item product-card-hover" style="padding: 5px; width: 16.66%;"> <!-- 16.66% ensures 6 items per row -->
                    <div class="card" style="width: 100%; height: 285px;">
                        <img src="{{ $product->images->first() ? Storage::url($product->images->first()->product_img_path1) : 'https://via.placeholder.com/80' }}"
                             class="card-img-top"
                             alt="{{ $product->product_name }}">
                        <div class="card-body" style="padding:10px;">
                            <h6 class="card-title mb-1">{{ $product->product_name }}</h6>
                            <p class="card-price mb-1">₱{{ number_format($product->price, 2) }}</p>
                            <p class="card-reviews">
                                {{-- Display stars based on the rating if available --}}
                                @if($product->averageRating > 0)
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($product->averageRating))
                                            <i class="fa-solid fa-star" style="color: #FFD700;"></i>
                                        @elseif ($i - $product->averageRating < 1)
                                            <i class="fa-solid fa-star-half-stroke" style="color: #FFD700;"></i>
                                        @else
                                            <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                        @endif
                                    @endfor
                                    <span class="rating-value">{{ $product->averageRating }} / 5</span>
                                @else
                                    {{-- Display empty stars if no reviews --}}
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                @endif
                            </p>
                            <div class="action-buttons" style="position: absolute; bottom: 10px; padding:6px;">
                                <a href="#" class="btn btn-custom add-to-cart" data-product-id="{{ $product->product_id }}">
                                    Add to Cart
                                </a>
                                <a href="#"
                                   class="btn {{ !empty($favorites) && in_array($product->product_id, $favorites) ? 'btn-danger' : 'btn-outline-danger' }} favorite-button"
                                   data-product-id="{{ $product->product_id }}"
                                   style="width: 2rem; padding: 0.2rem 0; "
                                   title="{{ !empty($favorites) && in_array($product->product_id, $favorites) ? 'Unfavorite' : 'Favorite' }}">
                                    <i class="fas fa-heart {{ !empty($favorites) && in_array($product->product_id, $favorites) ? 'text-white' : '' }}"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
<div class="col-md-12 mt-4 homeallproduct-products-container">
    <h3>All Products</h3>
    <hr class="line">
    <div class="homeallproduct-products-row d-flex flex-wrap justify-content-start">
        @foreach($products as $product)
            <a href="{{ route('product.view', $product->product_id) }}" class="product-link">
                <div class="product-item product-card-hover" style="padding: 5px; width: 16.66%;"> <!-- 16.66% ensures 6 items per row -->
                    <div class="card" style="width: 100%; height:285px;">
                        <img src="{{ $product->images->first() ? Storage::url($product->images->first()->product_img_path1) : 'https://via.placeholder.com/150' }}"
                             class="card-img-top"
                             alt="{{ $product->product_name }}">
                        <div class="card-body" style="padding:10px;">
                            <h6 class="card-title mb-1">{{ $product->product_name }}</h6>
                            <p class="card-price mb-1">₱{{ number_format($product->price, 2) }}</p>
                            <p class="card-reviews">
                                {{-- Display stars based on the rating if available --}}
                                @if($product->averageRating > 0)
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($product->averageRating))
                                            <i class="fa-solid fa-star" style="color: #FFD700;"></i>
                                        @elseif ($i - $product->averageRating < 1)
                                            <i class="fa-solid fa-star-half-stroke" style="color: #FFD700;"></i>
                                        @else
                                            <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                        @endif
                                    @endfor
                                    <span class="rating-value">{{ $product->averageRating }} / 5</span>
                                @else
                                    {{-- Display empty stars if no reviews --}}
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                    <i class="fa-regular fa-star" style="color: #C0C0C0;"></i>
                                @endif
                            </p>
                            <div class="action-buttons" style="position: absolute; bottom: 10px; padding:6px;">
                                <a href="#" class="btn btn-custom add-to-cart" data-product-id="{{ $product->product_id }}">
                                    Add to Cart
                                </a>
                                <a href="#"
                                   class="btn {{ !empty($favorites) && in_array($product->product_id, $favorites) ? 'btn-danger' : 'btn-outline-danger' }} favorite-button"
                                   data-product-id="{{ $product->product_id }}"
                                   style="width: 2rem; padding: 0.2rem 0;"
                                   title="{{ !empty($favorites) && in_array($product->product_id, $favorites) ? 'Unfavorite' : 'Favorite' }}">
                                    <i class="fas fa-heart {{ !empty($favorites) && in_array($product->product_id, $favorites) ? 'text-white' : '' }}"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
