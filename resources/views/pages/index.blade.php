@extends('layouts.app')

@section('content')

@include('layouts.menubar')
@include('layouts.slider')

@php
$featured = DB::table('products')->where('status',1)->orderBy('id','desc')->limit(12)->get();

$trend = DB::table('products')->where('status',1)->where('trend',1)->orderBy('id','desc')->limit(8)->get();

$best = DB::table('products')->where('status',1)->where('best_rated',1)->orderBy('id','desc')->limit(8)->get();

$hot = DB::table('products')
->join('brands','products.brand_id','brands.id')
->select('products.*','brands.brand_name')
->where('products.status',1)->where('hot_deal',1)->orderBy('id','desc')->limit(3)
->get();

@endphp

<!-- Deals of the week -->

<div class="deals_featured mt-5">
    <div class="container">
        <div class="row">
            <div class="col d-flex flex-lg-row flex-column align-items-center justify-content-start">

                <!-- Deals -->

                <div class="deals">
                    <div class="deals_title">Deals of the Week</div>
                    <div class="deals_slider_container">

                        <!-- Deals Slider -->
                        <div class="owl-carousel owl-theme deals_slider">

                            @foreach($hot as $ht)
                            <!-- Deals Item -->
                            <div class="owl-item deals_item">
                                <div class="deals_image"><img src="{{ asset( $ht->image_one )}}" alt=""></div>
                                <div class="deals_content">
                                    <div class="deals_info_line d-flex flex-row justify-content-start">
                                        <div class="deals_item_category"><a href="#">{{ $ht->brand_name }}</a></div>

                                        @if($ht->discount_price == NULL)
                                        @else
                                        <div class="deals_item_price_a ml-auto">৳{{ $ht->selling_price }}</div>
                                        @endif


                                    </div>
                                    <div class="deals_info_line d-flex flex-row justify-content-start">
                                        <div class="deals_item_name">{{ $ht->product_name }}</div>

                                        @if($ht->discount_price == NULL)
                                        <div class="deals_item_price ml-auto">৳{{ $ht->selling_price }}</div>
                                        @else

                                        @endif

                                        @if($ht->discount_price != NULL)
                                        <div class="deals_item_price ml-auto">৳{{ $ht->discount_price }}</div>
                                        @else

                                        @endif



                                    </div>
                                    <div class="available">
                                        <div class="available_line d-flex flex-row justify-content-start">
                                            <div class="available_title">Available: <span>{{ $ht->product_quantity  }}</span></div>
                                            <div class="sold_title ml-auto">Already sold: <span>60</span></div>
                                        </div>
                                        <div class="available_bar"><span style="width:40%"></span></div>
                                    </div>
                                    
                                </div>
                            </div>
                            @endforeach


                        </div>

                    </div>

                    <div class="deals_slider_nav_container">
                        <div class="deals_slider_prev deals_slider_nav"><i class="fas fa-chevron-left ml-auto"></i></div>
                        <div class="deals_slider_next deals_slider_nav"><i class="fas fa-chevron-right ml-auto"></i></div>
                    </div>
                </div>

                <!-- Featured -->
                <div class="featured">
                    <div class="tabbed_container">
                        <div class="tabs">
                            <ul class="clearfix">
                                <li class="active">Featured</li>

                            </ul>
                            <div class="tabs_line"><span></span></div>
                        </div>

                        <!-- Product Panel -->
                        <div class="product_panel panel active">
                            <div class="featured_slider slider">


                                @foreach($featured as $row)
                                <!-- Slider Item -->
                                <div class="featured_slider_item">
                                    <div class="border_active"></div>
                                    <div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                        <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset( $row->image_one )}}" alt="" style="height: 120px; width: 100px;"></div>
                                        <div class="product_content">

                                            @if($row->discount_price == NULL)
                                            <div class="product_price discount">৳{{ $row->selling_price }}<span> </div>
                                            @else
                                            <div class="product_price discount">৳{{ $row->discount_price }}<span>৳{{ $row->selling_price }}</span></div>
                                            @endif



                                            <div class="product_name">
                                                <div><a href="{{ url('product/details/'.$row->id.'/'.$row->product_name) }}">{{ $row->product_name }}</a></div>
                                            </div>


                                            <!--   <div class="product_extras">
                      
     <button class="product_cart_button addcart" data-id="{{ $row->id }}">Add to Cart</button>
                </div>
            </div> -->

                                            <div class="product_extras">

                                                <button id="{{ $row->id }}" class="product_cart_button addcart" data-toggle="modal" data-target="#cartmodal" onclick="productview(this.id)">Add to Cart</button>
                                            </div>
                                        </div>


                                        <button class="addwishlist" data-id="{{ $row->id }}">
                                            <div class="product_fav"><i class="fas fa-heart"></i></div>
                                        </button>


                                        <ul class="product_marks">
                                            @if($row->discount_price == NULL)
                                            <li class="product_mark product_discount" style="background: blue;">New</li>
                                            @else
                                            <li class="product_mark product_discount">
                                                @php
                                                $amount = $row->selling_price - $row->discount_price;
                                                $discount = $amount/$row->selling_price*100;

                                                @endphp

                                                {{ intval($discount) }}%

                                            </li>
                                            @endif



                                        </ul>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                            <div class="featured_slider_dots_cover"></div>
                        </div>



                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<!-- Banner -->
@php
$mid = DB::table('products')
->join('categories','products.category_id','categories.id')
->join('brands','products.brand_id','brands.id')
->select('products.*','brands.brand_name','categories.category_name')
->where('products.mid_slider',1)->orderBy('id','DESC')->limit(3)
->get();

@endphp


<div class="banner_2 mt-5">
    <div class="banner_2_background" style="background-image:url({{ asset('public/frontend/images/banner_2_background.png')}})"></div>
    <div class="banner_2_container">
        <div class="banner_2_dots"></div>
        <!-- Banner 2 Slider -->

        <div class="owl-carousel owl-theme banner_2_slider">
            @foreach($mid as $row)
            <!-- Banner 2 Slider Item -->
            <div class="owl-item">
                <div class="banner_2_item ">
                    <div class="container fill_height">
                        <div class="row fill_height">
                            <div class="col-lg-4 col-md-6 fill_height">
                                <div class="banner_2_content">
                                    <div class="banner_2_category">
                                        <h4>{{ $row->category_name }}</h4>
                                    </div>
                                    <div class="banner_2_title">{{ $row->product_name }}</div>
                                    <div class="banner_2_text">
                                        <h4> {{ $row->brand_name }}</h4> <br>
                                        <h2>৳{{ $row->selling_price }} </h2>

                                    </div>
                                    <div class="button banner_2_button"><a href="#">Explore</a></div>
                                </div>

                            </div>
                            <div class="col-lg-8 col-md-6 fill_height">
                                <div class="banner_2_image_container">
                                    <div class="banner_2_image"><img src="{{ asset( $row->image_one )}} " alt="" style="height: 300px; width: 250px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>


<!-- Hot New Category One -->

@php
$cats = DB::table('categories')->skip(1)->first();
$catid = $cats->id;

$product = DB::table('products')->where('category_id',$catid)->where('status',1)->limit(10)->orderBy('id','DESC')->get();

@endphp

<div class="new_arrivals">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="tabbed_container">
                    <div class="tabs clearfix tabs-right">
                        <div class="new_arrivals_title">{{ $cats->category_name }}</div>
                        <ul class="clearfix">
                            <li class="active"> </li>

                        </ul>
                        <div class="tabs_line"><span></span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="z-index:1;">

                            <!-- Product Panel -->
                            <div class="product_panel panel active">
                                <div class="arrivals_slider slider">

                                    @foreach($product as $row)
                                    <!-- Slider Item -->
                                    <div class="featured_slider_item">
                                        <div class="border_active"></div>
                                        <div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                            <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset( $row->image_one )}}" alt="" style="height: 120px; width: 100px;"></div>
                                            <div class="product_content">

                                                @if($row->discount_price == NULL)
                                                <div class="product_price discount">৳{{ $row->selling_price }}<span> </div>
                                                @else
                                                <div class="product_price discount">৳{{ $row->discount_price }}<span>৳{{ $row->selling_price }}</span></div>
                                                @endif



                                                <div class="product_name">
                                                    <div><a href="product.html">{{ $row->product_name }}</a></div>
                                                </div>
                                                <div class="product_extras">
                                                    <div class="product_color">
                                                        <input type="radio" checked name="product_color" style="background:#b19c83">
                                                        <input type="radio" name="product_color" style="background:#000000">
                                                        <input type="radio" name="product_color" style="background:#999999">
                                                    </div>
                                                    <button class="product_cart_button">Add to Cart</button>
                                                </div>
                                            </div>


                                            <button class="addwishlist" data-id="{{ $row->id }}">
                                                <div class="product_fav"><i class="fas fa-heart"></i></div>
                                            </button>


                                            <ul class="product_marks">
                                                @if($row->discount_price == NULL)
                                                <li class="product_mark product_discount" style="background: blue;">New</li>
                                                @else
                                                <li class="product_mark product_discount">
                                                    @php
                                                    $amount = $row->selling_price - $row->discount_price;
                                                    $discount = $amount/$row->selling_price*100;

                                                    @endphp

                                                    {{ intval($discount) }}%

                                                </li>
                                                @endif



                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                                <div class="featured_slider_dots_cover"></div>
                            </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




<!-- Hot New Category Two -->

@php
$cats = DB::table('categories')->skip(3)->first();
$catid = $cats->id;

$product = DB::table('products')->where('category_id',$catid)->where('status',1)->limit(10)->orderBy('id','DESC')->get();

@endphp

<div class="new_arrivals">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="tabbed_container">
                    <div class="tabs clearfix tabs-right">
                        <div class="new_arrivals_title">{{ $cats->category_name }}</div>
                        <ul class="clearfix">
                            <li class="active"> </li>

                        </ul>
                        <div class="tabs_line"><span></span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="z-index:1;">

                            <!-- Product Panel -->
                            <div class="product_panel panel active">
                                <div class="arrivals_slider slider">

                                    @foreach($product as $row)
                                    <!-- Slider Item -->
                                    <div class="featured_slider_item">
                                        <div class="border_active"></div>
                                        <div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                            <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset( $row->image_one )}}" alt="" style="height: 120px; width: 100px;"></div>
                                            <div class="product_content">

                                                @if($row->discount_price == NULL)
                                                <div class="product_price discount">৳{{ $row->selling_price }}<span> </div>
                                                @else
                                                <div class="product_price discount">৳{{ $row->discount_price }}<span>৳{{ $row->selling_price }}</span></div>
                                                @endif



                                                <div class="product_name">
                                                    <div><a href="product.html">{{ $row->product_name }}</a></div>
                                                </div>
                                                <div class="product_extras">
                                                    <div class="product_color">
                                                        <input type="radio" checked name="product_color" style="background:#b19c83">
                                                        <input type="radio" name="product_color" style="background:#000000">
                                                        <input type="radio" name="product_color" style="background:#999999">
                                                    </div>
                                                    <button class="product_cart_button">Add to Cart</button>
                                                </div>
                                            </div>


                                            <button class="addwishlist" data-id="{{ $row->id }}">
                                                <div class="product_fav"><i class="fas fa-heart"></i></div>
                                            </button>


                                            <ul class="product_marks">
                                                @if($row->discount_price == NULL)
                                                <li class="product_mark product_discount" style="background: blue;">New</li>
                                                @else
                                                <li class="product_mark product_discount">
                                                    @php
                                                    $amount = $row->selling_price - $row->discount_price;
                                                    $discount = $amount/$row->selling_price*100;

                                                    @endphp

                                                    {{ intval($discount) }}%

                                                </li>
                                                @endif



                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                                <div class="featured_slider_dots_cover"></div>
                            </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- service start -->
<section class="service section-padding mt-3">
    <div class="container">
        <h2 class="text-center mb-4">Shop Safely with e-techhouse</h2>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="service-details d-flex justify-content-evenly align-items-center">
                            <div class="icon">
                                <img src="public\frontend\images\free_delivery.png" class="img-fluid" alt="">
                            </div>
                            <div class="service-text">
                                <h3>Free Delivery</h3>
                                <p>Capped at ৳ 500 per order</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="service-details d-flex justify-content-evenly align-items-center">
                            <div class="icon">
                                <img src="public\frontend\images\money.png" class="img-fluid" alt="">
                            </div>
                            <div class="service-text">
                                <h3>Way to Buy</h3>
                                <p>14 Days to change your mind</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="service-details d-flex justify-content-evenly align-items-center">
                            <div class="icon">
                                <img src="public\frontend\images\gift.png" class="img-fluid" alt="">
                            </div>
                            <div class="service-text">
                                <h3>Gift Voucher</h3>
                                <p>Products added everyday</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- service end -->


<!-- Newsletter -->

<div class="newsletter" style="background-image:url(http://localhost/etechhouse/public/frontend/images/Newslatter-banner.png)">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                    <div class="newsletter_title_container">
                        <div class="newsletter_icon"><img src="{{ asset('public/frontend/images/send.png')}}" alt=""></div>
                        <div class="newsletter_title">Sign up for Newsletter</div>
                        <div class="newsletter_text">
                            <p>...and receive 15% coupon for first shopping.</p>
                        </div>
                    </div>
                    <div class="newsletter_content clearfix">
                        <form action="{{ route('store.newslater') }}" method="post" class="newsletter_form">
                            @csrf
                            <input type="email" class="newsletter_input" required="required" placeholder="Enter your email address" name="email">
                            <button class="newsletter_button" type="submit">Subscribe</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="cartmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLavel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLavel">Product Quick View</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="" id="pimage" style="height: 220px; width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title text-center" id="pname"> </h5>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item">Product Code:<span id="pcode"></span> </li>
                            <li class="list-group-item">Category: <span id="pcat"></span></li>
                            <li class="list-group-item">Subcategory: <span id="psub"></span></li>
                            <li class="list-group-item">Brand:<span id="pbrand"></span> </li>
                            <li class="list-group-item">Stock: <span class="badge" style="background: green;color: white;"> Available</span> </li>
                        </ul>

                    </div>

                    <div class="col-md-4">

                        <form method="post" action="{{ route('insert.into.cart') }}">
                            @csrf

                            <input type="hidden" name="product_id" id="product_id">

                            <div class="form-group">
                                <label for="exampleInputcolor">Color</label>
                                <select name="color" class="form-control" id="color">

                                </select>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputcolor">Size</label>
                                <select name="size" class="form-control" id="size">

                                </select>

                            </div>


                            <div class="form-group">
                                <label for="exampleInputcolor">Quantity</label>
                                <input type="number" class="form-control" name="qty" value="1">
                            </div>


                            <button type="submit" class="btn btn-success">Add to Cart </button>

                        </form>

                    </div>

                </div>
            </div>




            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>







<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script type="text/javascript">
    function productview(id) {
        $.ajax({
            url: "{{ url('/cart/product/view/') }}/" + id,
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('#pcode').text(data.product.product_code);
                $('#pcat').text(data.product.category_name);
                $('#psub').text(data.product.subcategory_name);
                $('#pbrand').text(data.product.brand_name);
                $('#pname').text(data.product.product_name);
                $('#pimage').attr('src', data.product.image_one);
                $('#product_id').val(data.product.id);

                var d = $('select[name="color"]').empty();
                $.each(data.color, function(key, value) {
                    $('select[name="color"]').append('<option value="' + value + '">' + value + '</option>');
                });

                var d = $('select[name="size"]').empty();
                $.each(data.size, function(key, value) {
                    $('select[name="size"]').append('<option value="' + value + '">' + value + '</option>');
                });


            }
        })
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.addwishlist').on('click', function() {
            var id = $(this).data('id');
            if (id) {
                $.ajax({
                    url: " {{ url('add/wishlist/') }}/" + id,
                    type: "GET",
                    datType: "json",
                    success: function(data) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        if ($.isEmptyObject(data.error)) {

                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            })
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: data.error
                            })
                        }


                    },
                });

            } else {
                alert('danger');
            }
        });

    });
</script>




@endsection