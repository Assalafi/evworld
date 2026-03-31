@extends('layouts.frontend')

@section('title', __('Home'))
@php $gtext = gtext(); @endphp

@section('meta-content')
    <meta name="keywords" content="{{ $gtext['og_keywords'] }}" />
    <meta name="description" content="{{ $gtext['og_description'] }}" />
    <meta property="og:title" content="{{ $gtext['og_title'] }}" />
    <meta property="og:site_name" content="{{ $gtext['site_name'] }}" />
    <meta property="og:description" content="{{ $gtext['og_description'] }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('media/' . $gtext['og_image']) }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />
    @if ($gtext['fb_publish'] == 1)
        <meta name="fb:app_id" property="fb:app_id" content="{{ $gtext['fb_app_id'] }}" />
    @endif
    <meta name="twitter:card" content="summary_large_image">
    @if ($gtext['twitter_publish'] == 1)
        <meta name="twitter:site" content="{{ $gtext['twitter_id'] }}">
        <meta name="twitter:creator" content="{{ $gtext['twitter_id'] }}">
    @endif
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $gtext['og_title'] }}">
    <meta name="twitter:description" content="{{ $gtext['og_description'] }}">
    <meta name="twitter:image" content="{{ asset('media/' . $gtext['og_image']) }}">
@endsection

@section('header')
    @include('frontend.partials.header')
@endsection

@section('content')
    <!-- Home Slider - Products from Categories -->
    <div class="slider-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="home-slider owl-carousel">
						@foreach ($slider as $product)
						<div class="slider-item">
							<div class="product-slider-card" style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); background: #fff; transition: transform 0.3s ease;">
								<a href="{{ route('frontend.product', [$product->id, $product->slug]) }}" class="d-block">
									<div class="product-image" style="position: relative; height: 300px; overflow: hidden;">
										<img src="{{ asset('media/' . $product->f_thumbnail) }}" 
											 alt="{{ $product->title }}" 
											 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
											 onmouseover="this.style.transform='scale(1.05)'"
											 onmouseout="this.style.transform='scale(1)'" />
										
										@if ($product->labelname != '')
											<span class="product-label" style="position: absolute; top: 15px; left: 15px; background: {{ $product->labelcolor }}; color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">{{ $product->labelname }}</span>
										@endif
										
										<div class="category-badge" style="position: absolute; top: 15px; right: 15px; background: rgba(74, 144, 226, 0.9); color: #fff; padding: 8px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">
											{{ $product->categoryname }}
										</div>
									</div>
								</a>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- /Home Slider/ -->
    


    <!-- New Arrivals Section -->
    <style>
        @media (max-width: 768px) {
            .item-card table {
                font-size: 0.75rem;
            }

            .item-card table i {
                font-size: 16px;
            }

            .item-card table div {
                white-space: normal !important;
            }
        }
    </style>
    {{-- Dynamic Category Sections --}}
    @foreach($categories_with_products as $categoryData)
    <div class="section">
        <div class="container">
            {{-- Dynamic Category Heading --}}
            <div class="row mb-3">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <div class="heading-wrapper" style="position: relative; display: inline-block; margin-bottom: 0px;">
                            {{-- Decorative line before title --}}
                            <div style="position: absolute; top: 50%; left: -60px; width: 45px; height: 2px; background: linear-gradient(90deg, transparent, #4a90e2); transform: translateY(-50%);"></div>
                            
                            {{-- Dynamic Category Title --}}
                            <h5 class="title" style="
                                font-size: 0.9rem;
                                font-weight: 700;
                                color: #2c3e50;
                                margin: 0;
                                position: relative;
                                text-transform: uppercase;
                                text-shadow: 0 2px 4px rgba(0,0,0,0.1);
                            ">
                                @if(stripos($categoryData['category']->name, 'electric') !== false)
                                    <i class="bi bi-lightning-charge" style="color: #4a90e2; font-size: 1.5rem; margin-right: 8px; vertical-align: middle;"></i>
                                @endif
                                {{ $categoryData['category']->name }}
                                @if(stripos($categoryData['category']->name, 'vehicle') !== false || stripos($categoryData['category']->name, 'car') !== false)
                                    <i class="bi bi-ev-station" style="color: #4a90e2; font-size: 1.5rem; margin-left: 8px; vertical-align: middle;"></i>
                                @elseif(stripos($categoryData['category']->name, 'bike') !== false)
                                    <i class="bi bi-bicycle" style="color: #4a90e2; font-size: 1.5rem; margin-left: 8px; vertical-align: middle;"></i>
                                @endif
                            </h5>
                            
                            {{-- Decorative line after title --}}
                            <div style="position: absolute; top: 50%; right: -60px; width: 45px; height: 2px; background: linear-gradient(270deg, transparent, #4a90e2); transform: translateY(-50%);"></div>
                        </div>
                    </div>
                </div>
            </div>
			
			{{-- Mobile responsive styles --}}
			<style>
				@media (max-width: 768px) {
					.heading-wrapper h5.title {
						font-size: 1.2rem !important;
					}
					
					.heading-wrapper h5.title i {
						font-size: 1.2rem !important;
					}
					
					.heading-wrapper div[style*="position: absolute"] {
						display: none !important;
					}
					
					.heading-wrapper p {
						font-size: 1rem !important;
						padding: 0px !important;
					}
				}
				
				@media (max-width: 480px) {
					.heading-wrapper h5.title {
						font-size: 1rem !important;
					}
					
					.heading-wrapper h5.title i {
						font-size: 1rem !important;
						margin: 0 5px !important;
					}
				}
			</style>
            {{-- Products Grid for this Category --}}
            <div class="row">
                @foreach ($categoryData['products'] as $row)
                    <div class="col-lg-3">
                        <div class="item-card mb25">
                            <div class="item-image" style="width: 100%; max-width: 600px; height: auto; overflow: hidden; position: relative;">
                                <a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">
                                    <img src="{{ asset('media/' . $row->f_thumbnail) }}" alt="{{ $row->title }}"
                                        style="width: 100%; height: auto; max-width: 600px; object-fit: contain; display: block;"
                                        loading="lazy" />
                                </a>

                                @if ($row->labelname != '')
                                    <div style="position: absolute; top: 10px; left: 10px; z-index: 10;">
                                        <span style="background:{{ $row->labelcolor }}; color: white; padding: 2px 5px; font-size: 14px; border-radius: 5px;">
                                            {{ $row->labelname }}
                                        </span>
                                    </div>
                                @endif

                                @if ($row->availability != '')
                                    <div style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                                        <span style="background: {{ $row->availability == 'Sold Out' ? '#ff0000' : $row->labelcolor }}; color: white; padding: 2px 5px; font-size: 14px; border-radius: 5px;">
                                            {{ $row->availability }}
                                        </span>
                                    </div>
                                @endif

                                @if ($row->variation_color != '')
                                    <ul class="color-list" style="position: absolute; bottom: 10px; left: 10px; display: flex; gap: 5px; list-style: none; padding: 0; margin: 0; z-index: 10;">
                                        @foreach (explode(',', $row->variation_color) as $color)
                                            @php $color_array = explode('|', $color); @endphp
                                            <li style="background:{{ $color_array[1] }}; width: 20px; height: 20px; border-radius: 50%; border: 1px solid #fff;"></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <!-- Rest of your card content remains exactly the same -->
                            <div
                                style="display: flex; justify-content: space-between; margin-bottom: 5px; align-items: flex-start;">
                                <div style="flex: 1; padding-right: 10px;">
                                    <h4 class="item-title" style="margin: 0 0 3px 0; font-size: 15px; line-height: 1.3;">
                                        <a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"
                                            style="color: #333;">
                                            {{ str_limit($row->title) }}
                                        </a>
                                    </h4>
                                    <div class="brand" style="font-size: 13px; color: #666; line-height: 1.3;">
                                        <a href="{{ route('frontend.brand', [$row->brand_id, str_slug($row->brandname)]) }}"
                                            style="color: #666;">
                                            {{ str_limit($row->brandname) }}
                                        </a>
                                    </div>
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: flex-end;">
                                    @if ($row->sale_price != '')
                                        @if ($gtext['currency_position'] == 'left')
                                            <div class="item-price"
                                                style="font-weight: bold; color: #333; font-size: 16px; white-space: nowrap; line-height: 1.3;">
                                                {{ $gtext['currency_icon'] }}{{ number_format($row->sale_price, 2) }}
                                            </div>
                                        @else
                                            <div class="item-price"
                                                style="font-weight: bold; color: #333; font-size: 16px; white-space: nowrap; line-height: 1.3;">
                                                {{ number_format($row->sale_price, 2) }}{{ $gtext['currency_icon'] }}
                                            </div>
                                        @endif
                                    @endif
                                    @if ($row->old_price != '')
                                        @if ($gtext['currency_position'] == 'left')
                                            <div class="old-item-price"
                                                style="font-size: 13px; color: #999; text-decoration: line-through; white-space: nowrap; line-height: 1.3;">
                                                {{ $gtext['currency_icon'] }}{{ number_format($row->old_price, 2) }}</div>
                                        @else
                                            <div class="old-item-price"
                                                style="font-size: 13px; color: #999; text-decoration: line-through; white-space: nowrap; line-height: 1.3;">
                                                {{ number_format($row->old_price, 2) }}{{ $gtext['currency_icon'] }}</div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <table
                                style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 0.85rem; table-layout: fixed;">
                                <tr style="text-align: center;">
                                    <td style="padding: 6px; border-right: 1px solid #f0f0f0; word-wrap: break-word;">
                                        <i style="font-size: 22px; color: #4a90e2;" class="bi bi-battery-full"></i>
                                        <div
                                            style="font-weight: 600; margin: 3px 0; font-size: 0.9rem; white-space: nowrap;">
                                            {{ $row -> battery ?? '0' }} kWh</div>
                                        <div style="color: #777;">Battery</div>
                                    </td>
                                    <td style="padding: 6px; border-right: 1px solid #f0f0f0; word-wrap: break-word;">
                                        <img src="{{ asset('frontend/images/distance1.png') }}" alt="Range" style="width: 31px; height: 31px; vertical-align: middle;">
                                        <div
                                            style="font-weight: 600; margin: 3px 0; font-size: 0.9rem; white-space: nowrap;">
                                            {{ $row -> range ?? '0' }} km</div>
                                        <div style="color: #777;">Range</div>
                                    </td>
                                    <td style="padding: 6px; border-right: 1px solid #f0f0f0; word-wrap: break-word;">
                                        <i style="font-size: 22px; color: #4a90e2;" class="bi bi-lightning-charge"></i>
                                        <div
                                            style="font-weight: 600; margin: 3px 0; font-size: 0.9rem; white-space: nowrap;">
                                            @php
                                                $minutes = $row->charging ?? 0;
                                                if ($minutes >= 60) {
                                                    $hours = floor($minutes / 60);
                                                    echo $hours . ($hours == 1 ? ' hr' : ' hrs');
                                                } else {
                                                    echo $minutes . ($minutes == 1 ? ' min' : ' mins');
                                                }
                                            @endphp
                                        </div>
                                        <div style="color: #777;">Charging</div>
                                    </td>
                                    <td style="padding: 6px; word-wrap: break-word;">
                                        <i style="font-size: 22px; color: #4a90e2;" class="bi bi-speedometer2"></i>
                                        <div
                                            style="font-weight: 600; margin: 3px 0; font-size: 0.9rem; white-space: nowrap;">
                                            {{ $row -> mileage ?? '0' }} km</div>
                                        <div style="color: #777;">Mileage</div>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- Mobile-responsive pagination styles --}}
            <style>
                .mobile-pagination .pagination {
                    margin: 0;
                    justify-content: center;
                }
                
                @media (max-width: 768px) {
                    .mobile-pagination .page-link {
                        padding: 8px 12px !important;
                        font-size: 14px !important;
                        min-width: 36px !important;
                    }
                    
                    .mobile-pagination .prev-next-text {
                        display: none;
                    }
                    
                    .mobile-pagination .pagination {
                        flex-wrap: wrap;
                        gap: 2px;
                    }
                    
                    .mobile-pagination .page-item {
                        margin: 1px;
                    }
                }
                
                @media (max-width: 480px) {
                    .mobile-pagination .page-link {
                        padding: 6px 8px !important;
                        font-size: 12px !important;
                        min-width: 32px !important;
                    }
                    
                    .mobile-pagination .pagination {
                        gap: 1px;
                    }
                }
            </style>
            
            {{-- Pagination with nice buttons for this Category --}}
            @if($categoryData['products']->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="pagination-wrapper d-flex justify-content-center align-items-center mobile-pagination">
                        <nav aria-label="{{ $categoryData['category']->name }} Pagination">
                            <ul class="pagination pagination-lg">
                                {{-- Previous Page Link --}}
                                @if ($categoryData['products']->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link" style="background: #f8f9fa; border: 1px solid #dee2e6; color: #6c757d; padding: 12px 16px; border-radius: 8px 0 0 8px;">
                                            <i class="bi bi-chevron-left"></i> <span class="prev-next-text">Previous</span>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $categoryData['products']->previousPageUrl() }}" 
                                           style="background: #fff; border: 1px solid #4a90e2; color: #4a90e2; padding: 12px 16px; border-radius: 8px 0 0 8px; text-decoration: none; transition: all 0.3s ease;"
                                           onmouseover="this.style.background='#4a90e2'; this.style.color='#fff'"
                                           onmouseout="this.style.background='#fff'; this.style.color='#4a90e2'">
                                            <i class="bi bi-chevron-left"></i> <span class="prev-next-text">Previous</span>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($categoryData['products']->getUrlRange(1, $categoryData['products']->lastPage()) as $page => $url)
                                    @if ($page == $categoryData['products']->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link" 
                                                  style="background: #4a90e2; border: 1px solid #4a90e2; color: #fff; padding: 12px 16px; font-weight: 600; min-width: 48px; text-align: center;">
                                                {{ $page }}
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}"
                                               style="background: #fff; border: 1px solid #dee2e6; color: #495057; padding: 12px 16px; text-decoration: none; min-width: 48px; text-align: center; transition: all 0.3s ease;"
                                               onmouseover="this.style.background='#4a90e2'; this.style.color='#fff'; this.style.borderColor='#4a90e2'"
                                               onmouseout="this.style.background='#fff'; this.style.color='#495057'; this.style.borderColor='#dee2e6'">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($categoryData['products']->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $categoryData['products']->nextPageUrl() }}"
                                           style="background: #fff; border: 1px solid #4a90e2; color: #4a90e2; padding: 12px 16px; border-radius: 0 8px 8px 0; text-decoration: none; transition: all 0.3s ease;"
                                           onmouseover="this.style.background='#4a90e2'; this.style.color='#fff'"
                                           onmouseout="this.style.background='#fff'; this.style.color='#4a90e2'">
                                            <span class="prev-next-text">Next</span> <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link" style="background: #f8f9fa; border: 1px solid #dee2e6; color: #6c757d; padding: 12px 16px; border-radius: 0 8px 8px 0;">
                                            <span class="prev-next-text">Next</span> <i class="bi bi-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    
                    {{-- Pagination Info --}}
                    <div class="pagination-info text-center mt-3">
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            Showing {{ $categoryData['products']->firstItem() }} to {{ $categoryData['products']->lastItem() }} of {{ $categoryData['products']->total() }} results
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endforeach
    <!-- /Dynamic Category Sections/ -->


    <!--Add Part-->
    {{-- @if ($trending_data['is_publish'] == 1)
	<div class="add-part-section">
		<div class="add-bg" style="background-image:url({{ asset('media/'.$trending_data['image']) }})">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 offset-lg-4 col-md-12 col-sm-12 col-12">
						<div class="add-card">
							<h2>{{ $trending_data['title'] }}</h2>
							@if ($trending_data['short_desc'] != '')
							<p>{{ $trending_data['short_desc'] }}</p>
							@endif
							<a class="btn theme-btn" href="{{ $trending_data['url'] }}">{{ __('Shop Now') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif --}}
    <!-- /Add Part/ -->

    @if (Session::has('subscribePopupOff'))
    @else
        @if ($gtext['is_subscribe_popup'] == 1)
            <div class="modal fade" id="subscribe_popup" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content newsletter-card">
                        <div class="modal-header newsletter-header">
                            <button onclick="popup_modal_close()" type="button" class="btn-close"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body newsletter-body">
                            <h4>{{ __('Subscribe our newsletter') }}</h4>
                            <p class="mb20">{{ $gtext['subscribe_popup_desc'] }}</p>
                            <div class="newsletter-form">
                                <input name="newsletter_email" id="newsletter_email" type="email"
                                    placeholder="{{ __('Enter your email address') }}" />
                                <a class="btn theme-btn mt10 full newsletter_btn nletter_btn"
                                    href="javascript:void(0);">{{ __('Submit') }}</a>
                                <div class="newsletter_msg mt5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Wait for the main scripts.js to initialize the carousel
        setTimeout(function() {
            var $slider = $('.home-slider');
            var itemCount = $slider.find('.slider-item').length;
            
            console.log('Slider has', itemCount, 'items');
            
            // Only start autoplay if there are multiple items
            if (itemCount > 1) {
                var autoplayInterval;
                var isHovered = false;
                
                // Start autoplay
                function startAutoplay() {
                    if (!isHovered) {
                        autoplayInterval = setInterval(function() {
                            if (!isHovered) {
                                // Use the most reliable method that was working
                                var owlData = $slider.data('owl.carousel');
                                if (owlData) {
                                    owlData.next();
                                }
                            }
                        }, 3000); // 2 seconds
                    }
                }
                
                // Stop autoplay
                function stopAutoplay() {
                    clearInterval(autoplayInterval);
                }
                
                // Pause on hover
                $slider.hover(
                    function() {
                        isHovered = true;
                        stopAutoplay();
                    },
                    function() {
                        isHovered = false;
                        startAutoplay();
                    }
                );
                
                // Start autoplay initially
                startAutoplay();
                console.log('Autoplay started for', itemCount, 'slides');
            } else {
                console.log('Only one slide found, autoplay not needed');
            }
            
        }, 1000); // Wait for scripts.js to finish
    });
</script>
@endpush

@push('scripts')

    @if (Session::has('subscribePopupOff'))
    @else
        @if ($gtext['is_subscribe_popup'] == 1)
            <script type="text/javascript">
                (function($) {
                    'use strict';
                    var subscribePopupModal = new bootstrap.Modal(document.getElementById('subscribe_popup'), {
                        keyboard: false
                    });

                    subscribePopupModal.show();

                    //Subscribe for page
                    $(document).on("click", ".newsletter_btn", function(event) {
                        event.preventDefault();

                        var newsletterEmail = $("#newsletter_email").val();
                        var status = 'subscribed';

                        var nletter_btn = $('.nletter_btn').html();
                        var newsletter_recordid = '';

                        var newsletter_email = newsletterEmail.trim();

                        if (newsletter_email == '') {
                            $('.newsletter_msg').html(
                                '<p class="text-danger">The email address field is required.</p>');
                            return;
                        }

                        $.ajax({
                            type: 'POST',
                            url: base_url + '/frontend/saveSubscriber',
                            data: 'RecordId=' + newsletter_recordid + '&email_address=' + newsletter_email +
                                '&status=' + status,
                            beforeSend: function() {
                                $('.newsletter_msg').html('');
                                $('.nletter_btn').html(
                                    '<span class="spinner-border spinner-border-sm"></span> Please Wait...'
                                );
                            },
                            success: function(response) {
                                var msgType = response.msgType;
                                var msg = response.msg;

                                if (msgType == "success") {
                                    popup_modal_close();
                                    subscribePopupModal.hide();
                                    onSuccessMsg(msg);
                                } else {
                                    $('.newsletter_msg').html('<p class="text-danger">' + msg + '</p>');
                                }

                                $('.nletter_btn').html(nletter_btn);
                            }
                        });
                    });
                }(jQuery));

                function popup_modal_close() {
                    $.ajax({
                        type: 'POST',
                        url: base_url + '/frontend/subscribePopupOff',
                        data: 'PopupOff=OFF',
                        success: function(response) {}
                    });
                }
            </script>
        @endif
    @endif

@endpush
