# OSR Digital - Installation Guide

Welcome to OSR Digital, a comprehensive digital content distribution platform. This guide will help you install and set up the application quickly and easily.

## 🚀 Quick Installation

### Prerequisites

Before installing OSR Digital, make sure you have the following installed on your system:

- **PHP 8.1+** with extensions: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Composer** (latest version)
- **Node.js 18+** and npm
- **MySQL 8.0+** or **PostgreSQL 13+**
- **Web Server** (Apache/Nginx) or use Laravel's built-in server for development

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/osr-digital.git
   cd osr-digital
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database**
   Edit the `.env` file and update the database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=osr_digital
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run the installation command**
   ```bash
   php artisan osr:install --fresh
   ```

   This command will:
   - Run all database migrations
   - Seed the database with sample data
   - Clear application caches
   - Build frontend assets
   - Set up admin user

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   - Frontend: http://localhost:8000
   - Admin Panel: http://localhost:8000/admin
   - Default Admin Login:
     - Email: `admin@osrdigital.com`
     - Password: `password`

## 📋 What's Included

The installation includes:

### 🎬 Content Management
- **Film Categories**: Feature Films, Documentaries, Short Films, Series, Music Videos
- **Film Portfolio**: Sample films with ratings, descriptions, and metadata
- **News System**: Categories and sample news articles
- **Content Blocks**: Reusable content components

### 👥 Team Management
- **Teams**: Leadership, Content, and Technical teams
- **Team Members**: Sample team members with bios and positions
- **Team Values**: Core company values and principles

### 🛠️ Services & Features
- **Services**: Content Distribution, Digital Marketing, Analytics
- **Distribution Services**: Streaming Platforms, YouTube, Social Media
- **Partnership Benefits**: Global Reach, Revenue Sharing, Marketing Support

### 📄 Pages & Content
- **Dynamic Pages**: Home, About, Portfolio, Contact, Team, Partners
- **Hero Sections**: Customizable hero sections for each page
- **Legal Pages**: Privacy Policy, Terms of Service, Cookie Policy
- **Testimonials**: Customer testimonials and reviews

### ⚙️ Settings & Configuration
- **Brand Settings**: Company name, colors, logos, contact info
- **Social Media**: Facebook, Twitter, LinkedIn, Instagram, YouTube
- **SEO Settings**: Meta titles, descriptions, keywords
- **Footer Settings**: Copyright, links, contact information

## 🔧 Advanced Configuration

### Mail Configuration

Update your `.env` file with mail settings:

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

For production, configure file storage:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

### Queue Configuration

For background jobs, configure queues:

```env
QUEUE_CONNECTION=database
```

Then run the queue worker:
```bash
php artisan queue:work
```

## 🎨 Customization

### Branding
1. Go to Admin Panel → Settings → Branding
2. Upload your logo and favicon
3. Update company name and tagline
4. Customize colors and theme

### Content
1. Edit pages in Admin Panel → Pages
2. Update hero sections in Admin Panel → Hero Sections
3. Manage content blocks in Admin Panel → Content Blocks
4. Add your own films, news, and team members

### Styling
1. Edit `resources/css/app.css` for custom styles
2. Update `tailwind.config.js` for theme customization
3. Modify components in `resources/js/components/`

## 🚀 Production Deployment

### Server Requirements
- PHP 8.1+
- MySQL 8.0+ or PostgreSQL 13+
- Web Server (Apache/Nginx)
- SSL Certificate
- Domain name

### Deployment Steps

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
- Check if admin user was created: `php artisan tinker` → `User::count()`
- Reset admin password: `php artisan tinker` → `User::first()->update(['password' => Hash::make('newpassword')])`

### Getting Help

- 📖 **Documentation**: https://codebundles.com/docs/osr-digital
- 💬 **Support**: https://codebundles.com/support
- 🐛 **Issues**: https://github.com/your-username/osr-digital/issues
- 📧 **Email**: support@codebundles.com

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Credits

Built with ❤️ by [CodeBundles](https://codebundles.com)

---

**Need help?** Contact our support team at support@codebundles.com or visit https://codebundles.com/support
