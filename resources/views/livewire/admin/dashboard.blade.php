<div>
    <style>
        .stat-card {
            background: #343a40;
            border-radius: 12px;
            padding: 1.5rem;
            color: white;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        /* Ensure Font Awesome icons are visible */
        .stat-card i.fas,
        .stat-card i.fa {
            display: inline-block !important;
            font-style: normal !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            line-height: 1 !important;
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
        }
    </style>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
        <p class="text-gray-600">Welcome back! Here's an overview of your content.</p>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-6">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-white-50 small mb-1" style="opacity: 0.9;">Film Portfolios</div>
                        <div class="h3 mb-0 text-white font-bold">{{ $stats['film_portfolios'] }}</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px;">
                        <i class="fas fa-film text-dark" style="font-size: 1.5rem; display: inline-block !important;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-white-50 small mb-1" style="opacity: 0.9;">Associates</div>
                        <div class="h3 mb-0 text-white font-bold">{{ $stats['associates'] }}</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px;">
                        <i class="fas fa-handshake text-dark" style="font-size: 1.5rem; display: inline-block !important;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-white-50 small mb-1" style="opacity: 0.9;">Testimonials</div>
                        <div class="h3 mb-0 text-white font-bold">{{ $stats['testimonials'] }}</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px;">
                        <i class="fas fa-quote-left text-dark" style="font-size: 1.5rem; display: inline-block !important;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-white-50 small mb-1" style="opacity: 0.9;">News Articles</div>
                        <div class="h3 mb-0 text-white font-bold">{{ $stats['news'] }}</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px;">
                        <i class="fas fa-newspaper text-dark" style="font-size: 1.5rem; display: inline-block !important;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row mb-6">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-white-50 small mb-1" style="opacity: 0.9;">Services</div>
                        <div class="h3 mb-0 text-white font-bold">{{ $stats['services'] }}</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px;">
                        <i class="fas fa-briefcase text-dark" style="font-size: 1.5rem; display: inline-block !important;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-white-50 small mb-1" style="opacity: 0.9;">Team Members</div>
                        <div class="h3 mb-0 text-white font-bold">{{ $stats['team_members'] }}</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px;">
                        <i class="fas fa-users text-dark" style="font-size: 1.5rem; display: inline-block !important;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-white-50 small mb-1" style="opacity: 0.9;">Hero Sliders</div>
                        <div class="h3 mb-0 text-white font-bold">{{ $stats['hero_sliders'] }}</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px;">
                        <i class="fas fa-images text-dark" style="font-size: 1.5rem; display: inline-block !important;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-white-50 small mb-1" style="opacity: 0.9;">Core Values</div>
                        <div class="h3 mb-0 text-white font-bold">{{ $stats['core_values'] }}</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px;">
                        <i class="fas fa-heart text-dark" style="font-size: 1.5rem; display: inline-block !important;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>