@extends('admin.layout')

@section('title', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

<!-- Stats Cards -->
<div id="stats-cards" class="row mb-4">
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
        <h3>{{ \App\Models\Associate::count() }}</h3>
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
        <h3>{{ \App\Models\FilmPortfolio::count() }}</h3>
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
        <h3>{{ \App\Models\Testimonial::count() }}</h3>
        <p>Testimonials</p>
      </div>
      <div class="icon">
        <i class="fas fa-quote-left"></i>
      </div>
    </div>
  </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('admin.associates.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-blue-100 rounded-lg mr-4">
                        <i class="fas fa-handshake text-blue-600 w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Manage Associates</h3>
                        <p class="text-sm text-gray-600">Add, edit, or manage associates</p>
                    </div>
                </a>

                <a href="{{ route('admin.film-portfolios.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-green-100 rounded-lg mr-4">
                        <i class="fas fa-film text-green-600 w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Film Portfolios</h3>
                        <p class="text-sm text-gray-600">Manage film portfolio and categories</p>
                    </div>
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-purple-100 rounded-lg mr-4">
                        <i class="fas fa-quote-left text-purple-600 w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Testimonials</h3>
                        <p class="text-sm text-gray-600">Manage customer testimonials</p>
                    </div>
                </a>

                <a href="{{ route('admin.settings') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-orange-100 rounded-lg mr-4">
                        <i class="fas fa-cog text-orange-600 w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Site Settings</h3>
                        <p class="text-sm text-gray-600">Manage global site configuration</p>
                    </div>
                </a>

                <a href="{{ route('admin.distribution-services.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-indigo-100 rounded-lg mr-4">
                        <i class="fas fa-truck text-indigo-600 w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Distribution Services</h3>
                        <p class="text-sm text-gray-600">Manage distribution services</p>
                    </div>
                </a>

                <a href="{{ route('admin.global-impact.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-pink-100 rounded-lg mr-4">
                        <i class="fas fa-chart-line text-pink-600 w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Global Impact</h3>
                        <p class="text-sm text-gray-600">Manage global impact statistics</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection
