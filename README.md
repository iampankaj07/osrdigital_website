# OSR Digital - Digital Content Distribution Platform

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![React](https://img.shields.io/badge/React-18.x-blue.svg)](https://reactjs.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Built by CodeBundles](https://img.shields.io/badge/Built%20by-CodeBundles-orange.svg)](https://codebundles.com)

A comprehensive digital content distribution platform built with Laravel 11, React 18, and Tailwind CSS. Perfect for content creators, studios, and distribution companies looking to manage and distribute their digital content across multiple platforms.

## 🌟 Features

### 🎬 Content Management
- **Film Portfolio Management** - Organize movies, documentaries, short films, and series
- **Category System** - Flexible categorization with custom colors and metadata
- **Media Library** - Integrated file management with image optimization
- **Content Blocks** - Reusable content components for dynamic pages
- **SEO Optimization** - Built-in SEO tools for better search visibility

### 📰 News & Blog System
- **News Management** - Create and manage news articles and blog posts
- **Category Organization** - Organize content with custom categories
- **Featured Content** - Highlight important articles and content
- **Publishing Workflow** - Draft, review, and publish content

### 👥 Team Management
- **Team Structure** - Organize team members by departments
- **Member Profiles** - Detailed team member profiles with bios and photos
- **Team Values** - Showcase company values and principles
- **Core Values** - Display organizational core values

### 🛠️ Services & Distribution
- **Service Management** - Showcase your services and offerings
- **Distribution Services** - Manage distribution channels and platforms
- **Partnership Benefits** - Highlight partnership advantages
- **Trusted Partners** - Display partner logos and information

### 🎨 Modern UI/UX
- **Responsive Design** - Mobile-first, fully responsive design
- **Dark Mode Support** - Built-in dark/light theme switching
- **Fast Loading** - Optimized performance with skeleton loaders
- **Modern Components** - Beautiful, accessible UI components
- **Smooth Animations** - Engaging micro-interactions

### ⚙️ Admin Panel
- **Comprehensive Dashboard** - Complete admin control panel
- **Content Management** - Easy-to-use content management interface
- **User Management** - Role-based access control
- **Settings Management** - Centralized configuration
- **Analytics Integration** - Built-in analytics and reporting

## 📚 Documentation

### 📖 Complete Documentation Suite

- **[📋 Installation Guide](INSTALLATION.md)** - Step-by-step installation instructions
- **[🚀 Deployment Guide](SHARED_HOSTING_DEPLOYMENT.md)** - Production deployment on shared hosting
- **[📋 Deployment Checklist](DEPLOYMENT_CHECKLIST.md)** - Pre-deployment checklist
- **[✅ Ready for Deployment](READY_FOR_DEPLOYMENT.md)** - Final deployment summary
- **[🏠 Root Directory Setup](ROOT_DIRECTORY_SETUP.md)** - Setup when domain points to root
- **[🔧 Local Development](LOCAL_DEVELOPMENT_SETUP.md)** - Local development environment setup
- **[🌐 Subdomain Fix Guide](SUBDOMAIN_FIX_GUIDE.md)** - Troubleshooting subdomain issues
- **[🔌 API Documentation](API.md)** - Complete API reference
- **[🤝 Contributing Guidelines](CONTRIBUTING.md)** - How to contribute to the project
- **[📝 Code of Conduct](CODE_OF_CONDUCT.md)** - Community standards
- **[📊 Changelog](CHANGELOG.md)** - Version history and updates

### 🚀 Quick Start

#### Prerequisites

- **PHP 8.1+** with required extensions
- **Composer** (latest version)
- **Node.js 18+** and npm
- **MySQL 8.0+** or **PostgreSQL 13+**
- **Web Server** (Apache/Nginx) or Laravel's built-in server

#### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/osr-digital.git
   cd osr-digital
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=osr_digital
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run installation**
   ```bash
   php artisan osr:install --fresh
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   - **Frontend**: http://localhost:8000
   - **Admin Panel**: http://localhost:8000/admin
   - **Default Admin Login**:
     - Email: `admin@osrdigital.com`
     - Password: `password`

> 📖 **For detailed installation instructions, see [INSTALLATION.md](INSTALLATION.md)**

## 📋 What's Included

The installation includes a complete demo setup with:

### 🎬 Sample Content
- **5 Film Categories** - Feature Films, Documentaries, Short Films, Series, Music Videos
- **6 Sample Films** - Complete with ratings, descriptions, and metadata
- **News System** - Categories and sample articles
- **Team Members** - Sample team with bios and positions

### 📄 Pages & Content
- **Dynamic Pages** - Home, About, Portfolio, Contact, Team, Partners
- **Hero Sections** - Customizable hero sections for each page
- **Content Blocks** - Reusable components for dynamic content
- **Legal Pages** - Privacy Policy, Terms of Service, Cookie Policy

### ⚙️ Configuration
- **Brand Settings** - Company name, colors, logos, contact info
- **Social Media** - Facebook, Twitter, LinkedIn, Instagram, YouTube
- **SEO Settings** - Meta titles, descriptions, keywords
- **Footer Settings** - Copyright, links, contact information

## 🛠️ Technology Stack

### Backend
- **Laravel 11** - PHP framework
- **MySQL/PostgreSQL** - Database
- **Spatie Permissions** - Role-based access control
- **Laravel Livewire** - Dynamic admin interface
- **Laravel Mail** - Email functionality

### Frontend
- **React 18** - JavaScript library
- **Tailwind CSS** - Utility-first CSS framework
- **Vite** - Build tool and development server
- **React Router** - Client-side routing
- **Context API** - State management

### Additional Tools
- **Laravel Sanctum** - API authentication
- **Laravel Queue** - Background job processing
- **Laravel Cache** - Caching system
- **Laravel Storage** - File storage abstraction

## 📁 Project Structure

```
osr-digital/
├── app/
│   ├── Console/Commands/     # Custom Artisan commands
│   ├── Http/Controllers/     # API and web controllers
│   ├── Livewire/Admin/       # Admin panel components
│   ├── Models/              # Eloquent models
│   └── Helpers/             # Helper classes
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── js/                 # React components and pages
│   ├── css/                # Stylesheets
│   └── views/              # Blade templates
├── public/                 # Public assets
├── routes/                 # Route definitions
└── tests/                  # Test files
```

## 🎨 Customization

### Branding
1. Go to **Admin Panel → Settings → Branding**
2. Upload your logo and favicon
3. Update company name and tagline
4. Customize colors and theme

### Content
1. Edit pages in **Admin Panel → Pages**
2. Update hero sections in **Admin Panel → Hero Sections**
3. Manage content blocks in **Admin Panel → Content Blocks**
4. Add your own films, news, and team members

### Styling
1. Edit `resources/css/app.css` for custom styles
2. Update `tailwind.config.js` for theme customization
3. Modify components in `resources/js/components/`

## 🚀 Deployment

### 📚 Deployment Documentation

- **[🚀 Shared Hosting Deployment](SHARED_HOSTING_DEPLOYMENT.md)** - Complete guide for shared hosting
- **[📋 Deployment Checklist](DEPLOYMENT_CHECKLIST.md)** - Pre-deployment checklist
- **[✅ Ready for Deployment](READY_FOR_DEPLOYMENT.md)** - Final deployment summary
- **[🏠 Root Directory Setup](ROOT_DIRECTORY_SETUP.md)** - Setup when domain points to root
- **[🌐 Subdomain Fix Guide](SUBDOMAIN_FIX_GUIDE.md)** - Troubleshooting subdomain issues

### Production Requirements
- PHP 8.1+
- MySQL 8.0+ or PostgreSQL 13+
- Web Server (Apache/Nginx)
- SSL Certificate
- Domain name

### Quick Deployment Steps

1. **Upload files to server**
2. **Set up database**
3. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with production settings
   ```

4. **Install dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install && npm run build
   ```

5. **Run installation**
   ```bash
   php artisan osr:install --fresh
   ```

6. **Set up web server**
   - Point document root to `public/` directory
   - Configure URL rewriting
   - Set up SSL certificate

7. **Configure cron jobs**
   ```bash
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

> 📖 **For detailed deployment instructions, see [SHARED_HOSTING_DEPLOYMENT.md](SHARED_HOSTING_DEPLOYMENT.md)**

## 🔧 Configuration

### Mail Setup
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### File Storage
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

### Queue Configuration
```env
QUEUE_CONNECTION=database
```

## 📚 API Documentation

> 📖 **For complete API documentation, see [API.md](API.md)**

### Quick API Reference

#### Authentication
All API endpoints require authentication. Include the API token in the header:
```
Authorization: Bearer your-api-token
```

#### Key Endpoints

**Films**
- `GET /api/film-portfolios` - Get all films
- `GET /api/film-portfolios/{id}` - Get specific film
- `GET /api/film-categories` - Get film categories

**News**
- `GET /api/news` - Get all news articles
- `GET /api/news/{id}` - Get specific article
- `GET /api/news-categories` - Get news categories

**Team**
- `GET /api/team` - Get team information
- `GET /api/team-members` - Get team members

**Settings**
- `GET /api/settings` - Get public settings
- `GET /api/hero-sections` - Get hero sections

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Run specific test groups:
```bash
php artisan test --group=api
php artisan test --group=admin
```

## 🔍 Troubleshooting

### Common Issues

**Database connection error**
- Check database credentials in `.env`
- Ensure database server is running
- Verify database exists

**Permission errors**
- Set proper file permissions: `chmod -R 755 storage bootstrap/cache`
- Ensure web server can write to storage directories

**Frontend not loading**
- Run `npm run build` to build assets
- Check if `public/build/` directory exists
- Clear browser cache

**Admin panel not accessible**
- Check if admin user was created
- Reset admin password if needed

**Subdomain issues**
- See [Subdomain Fix Guide](SUBDOMAIN_FIX_GUIDE.md) for detailed troubleshooting

**Local development issues**
- See [Local Development Setup](LOCAL_DEVELOPMENT_SETUP.md) for setup help

### Getting Help

- 📖 **Installation Guide**: [INSTALLATION.md](INSTALLATION.md)
- 🚀 **Deployment Guide**: [SHARED_HOSTING_DEPLOYMENT.md](SHARED_HOSTING_DEPLOYMENT.md)
- 🌐 **Subdomain Issues**: [SUBDOMAIN_FIX_GUIDE.md](SUBDOMAIN_FIX_GUIDE.md)
- 🔧 **Local Development**: [LOCAL_DEVELOPMENT_SETUP.md](LOCAL_DEVELOPMENT_SETUP.md)
- 💬 **Support**: https://codebundles.com/support
- 🐛 **Issues**: [GitHub Issues](https://github.com/your-username/osr-digital/issues)
- 📧 **Email**: support@codebundles.com

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guidelines](CONTRIBUTING.md) for details.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Credits

- **Laravel** - The PHP framework
- **React** - The JavaScript library
- **Tailwind CSS** - The CSS framework
- **CodeBundles** - Development and support

## 📞 Support

- **Website**: https://codebundles.com
- **Email**: support@codebundles.com
- **Documentation**: https://codebundles.com/docs/osr-digital
- **GitHub**: https://github.com/your-username/osr-digital

## 📚 Complete Documentation Index

### 🚀 Getting Started
- **[📋 Installation Guide](INSTALLATION.md)** - Complete installation instructions
- **[🔧 Local Development](LOCAL_DEVELOPMENT_SETUP.md)** - Local development environment
- **[📊 Changelog](CHANGELOG.md)** - Version history and updates

### 🚀 Deployment & Production
- **[🚀 Shared Hosting Deployment](SHARED_HOSTING_DEPLOYMENT.md)** - Production deployment guide
- **[📋 Deployment Checklist](DEPLOYMENT_CHECKLIST.md)** - Pre-deployment checklist
- **[✅ Ready for Deployment](READY_FOR_DEPLOYMENT.md)** - Final deployment summary
- **[🏠 Root Directory Setup](ROOT_DIRECTORY_SETUP.md)** - Root directory configuration
- **[🌐 Subdomain Fix Guide](SUBDOMAIN_FIX_GUIDE.md)** - Subdomain troubleshooting

### 🔌 Development & API
- **[🔌 API Documentation](API.md)** - Complete API reference
- **[🤝 Contributing Guidelines](CONTRIBUTING.md)** - How to contribute
- **[📝 Code of Conduct](CODE_OF_CONDUCT.md)** - Community standards

### 📄 Legal & License
- **[📄 License](LICENSE)** - MIT License details

---

**Built with ❤️ by [CodeBundles](https://codebundles.com)**

*OSR Digital - Bringing stories to global screens*
