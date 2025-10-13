<div>
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Active</h3>
                    <p>Home Page</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['associates'] }}</h3>
                    <p>Associates</p>
                </div>
                <div class="icon">
                    <i class="fas fa-handshake"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['film_portfolios'] }}</h3>
                    <p>Film Portfolios</p>
                </div>
                <div class="icon">
                    <i class="fas fa-film"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['testimonials'] }}</h3>
                    <p>Testimonials</p>
                </div>
                <div class="icon">
                    <i class="fas fa-quote-left"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['news'] }}</h3>
                    <p>News Articles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['services'] }}</h3>
                    <p>Services</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cogs"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $stats['team_members'] }}</h3>
                    <p>Team Members</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.associates.index') }}" class="btn btn-block btn-outline-primary">
                                <i class="fas fa-handshake mr-2"></i>
                                Manage Associates
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.film-portfolios.index') }}" class="btn btn-block btn-outline-warning">
                                <i class="fas fa-film mr-2"></i>
                                Manage Film Portfolios
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-block btn-outline-danger">
                                <i class="fas fa-quote-left mr-2"></i>
                                Manage Testimonials
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.news.index') }}" class="btn btn-block btn-outline-info">
                                <i class="fas fa-newspaper mr-2"></i>
                                Manage News
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
