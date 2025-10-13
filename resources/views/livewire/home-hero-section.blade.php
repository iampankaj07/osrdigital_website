@if($heroSections->count() > 0)
    <div class="hero-section-swiper">
        <div class="swiper-container hero-swiper">
            <div class="swiper-wrapper">
                @foreach($heroSections as $heroSection)
                    <div class="swiper-slide hero-slide" style="{{ $heroSection->getBackgroundStyle() }}">
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="row align-items-center min-vh-100">
                                <div class="col-lg-8">
                                    <div class="hero-content" style="color: {{ $heroSection->text_color }};">
                                        @if($heroSection->title)
                                            <h1 class="hero-title display-4 font-weight-bold mb-4">
                                                {{ $heroSection->title }}
                                            </h1>
                                        @endif
                                        
                                        @if($heroSection->subtitle)
                                            <h2 class="hero-subtitle h3 mb-4 opacity-90">
                                                {{ $heroSection->subtitle }}
                                            </h2>
                                        @endif
                                        
                                        @if($heroSection->content)
                                            <p class="hero-description lead mb-5">
                                                {{ $heroSection->content }}
                                            </p>
                                        @endif
                                        
                                        @if($heroSection->shouldShowButton() || $heroSection->shouldShowSecondaryButton())
                                            <div class="hero-buttons">
                                                @if($heroSection->shouldShowButton())
                                                    <a href="{{ $heroSection->button_url }}" 
                                                       class="btn btn-primary btn-lg mr-3 mb-3">
                                                        {{ $heroSection->button_text }}
                                                    </a>
                                                @endif
                                                
                                                @if($heroSection->shouldShowSecondaryButton())
                                                    <a href="{{ $heroSection->button_url_secondary }}" 
                                                       class="btn btn-outline-light btn-lg mb-3">
                                                        {{ $heroSection->button_text_secondary }}
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Navigation -->
            <div class="swiper-button-next hero-nav-next"></div>
            <div class="swiper-button-prev hero-nav-prev"></div>
            
            <!-- Pagination -->
            <div class="swiper-pagination hero-pagination"></div>
        </div>
    </div>

    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    
    <!-- Swiper.js JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heroSwiper = new Swiper('.hero-swiper', {
                // Basic settings
                loop: {{ $heroSections->count() > 1 ? 'true' : 'false' }},
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                speed: 1000,
                
                // Navigation
                navigation: {
                    nextEl: '.hero-nav-next',
                    prevEl: '.hero-nav-prev',
                },
                
                // Pagination
                pagination: {
                    el: '.hero-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                
                // Effects
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                
                // Responsive breakpoints
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 0
                    },
                    768: {
                        slidesPerView: 1,
                        spaceBetween: 0
                    },
                    1024: {
                        slidesPerView: 1,
                        spaceBetween: 0
                    }
                }
            });
        });
    </script>

    <style>
        .hero-section-swiper {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 600px;
        }
        
        .hero-swiper {
            width: 100%;
            height: 100%;
        }
        
        .hero-slide {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: left;
        }
        
        .hero-title {
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 1.5rem;
        }
        
        .hero-description {
            font-size: 1.25rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .hero-buttons .btn {
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .hero-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }
        
        /* Navigation Styles */
        .hero-nav-next,
        .hero-nav-prev {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .hero-nav-next:hover,
        .hero-nav-prev:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }
        
        .hero-nav-next:after,
        .hero-nav-prev:after {
            font-size: 18px;
            font-weight: bold;
        }
        
        /* Pagination Styles */
        .hero-pagination {
            bottom: 30px;
        }
        
        .hero-pagination .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            width: 12px;
            height: 12px;
            margin: 0 8px;
            transition: all 0.3s ease;
        }
        
        .hero-pagination .swiper-pagination-bullet-active {
            background: white;
            transform: scale(1.2);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.25rem;
            }
            
            .hero-description {
                font-size: 1.1rem;
            }
            
            .hero-buttons .btn {
                padding: 10px 25px;
                font-size: 1rem;
            }
            
            .hero-content {
                text-align: center;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-description {
                font-size: 1rem;
            }
        }
    </style>
@else
    <div class="hero-section-placeholder">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-12 text-center">
                    <h1 class="display-4 font-weight-bold text-primary mb-4">
                        Welcome to Our Website
                    </h1>
                    <p class="lead text-muted mb-5">
                        Add hero sections from the admin panel to customize this area.
                    </p>
                    <a href="#" class="btn btn-primary btn-lg">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif