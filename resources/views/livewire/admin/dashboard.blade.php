<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Dashboard</h1>
            <p class="text-muted small mb-0">Welcome to the OSR Admin Panel</p>
        </div>
        <div class="text-muted small">
            <i class="fas fa-calendar-alt mr-1"></i>
            {{ now()->format('M d, Y') }}
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-film text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Film Portfolios</div>
                            <div class="h4 mb-0 text-dark">{{ $stats['film_portfolios'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-handshake text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Associates</div>
                            <div class="h4 mb-0 text-dark">{{ $stats['associates'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-quote-left text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Testimonials</div>
                            <div class="h4 mb-0 text-dark">{{ $stats['testimonials'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-newspaper text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">News Articles</div>
                            <div class="h4 mb-0 text-dark">{{ $stats['news'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-cogs text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Services</div>
                            <div class="h4 mb-0 text-dark">{{ $stats['services'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Team Members</div>
                            <div class="h4 mb-0 text-dark">{{ $stats['team_members'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-tags text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Film Categories</div>
                            <div class="h4 mb-0 text-dark">{{ $stats['film_categories'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">System Status</div>
                            <div class="h6 mb-0 text-success">Active</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 font-weight-normal">
                <i class="fas fa-bolt mr-2 text-warning"></i>
                Quick Actions
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('admin.film-portfolios.index') }}" class="btn btn-outline-primary btn-block d-flex align-items-center justify-content-center py-3">
                        <i class="fas fa-film mr-2"></i>
                        <div class="text-left">
                            <div class="font-weight-semibold">Film Portfolios</div>
                            <small class="text-muted">Manage films</small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('admin.associates.index') }}" class="btn btn-outline-success btn-block d-flex align-items-center justify-content-center py-3">
                        <i class="fas fa-handshake mr-2"></i>
                        <div class="text-left">
                            <div class="font-weight-semibold">Associates</div>
                            <small class="text-muted">Manage partners</small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-info btn-block d-flex align-items-center justify-content-center py-3">
                        <i class="fas fa-newspaper mr-2"></i>
                        <div class="text-left">
                            <div class="font-weight-semibold">News</div>
                            <small class="text-muted">Manage articles</small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-warning btn-block d-flex align-items-center justify-content-center py-3">
                        <i class="fas fa-quote-left mr-2"></i>
                        <div class="text-left">
                            <div class="font-weight-semibold">Testimonials</div>
                            <small class="text-muted">Manage reviews</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- System Overview -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 font-weight-normal">
                <i class="fas fa-chart-pie mr-2 text-info"></i>
                System Overview
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6 class="text-muted mb-3">Content Management</h6>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Film Portfolios</span>
                        <span class="badge badge-primary">{{ $stats['film_portfolios'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">News Articles</span>
                        <span class="badge badge-info">{{ $stats['news'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Testimonials</span>
                        <span class="badge badge-warning">{{ $stats['testimonials'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Film Categories</span>
                        <span class="badge badge-warning">{{ $stats['film_categories'] }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted mb-3">Team & Partners</h6>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Team Members</span>
                        <span class="badge badge-dark">{{ $stats['team_members'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Associates</span>
                        <span class="badge badge-success">{{ $stats['associates'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Trusted Partners</span>
                        <span class="badge badge-success">{{ $stats['trusted_partners'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Services</span>
                        <span class="badge badge-secondary">{{ $stats['services'] }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted mb-3">System Components</h6>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Distribution Services</span>
                        <span class="badge badge-info">{{ $stats['distribution_services'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Partnership Benefits</span>
                        <span class="badge badge-success">{{ $stats['partnership_benefits'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Team Values</span>
                        <span class="badge badge-primary">{{ $stats['team_values'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Core Values</span>
                        <span class="badge badge-primary">{{ $stats['core_values'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>