# OSR Digital API Documentation

This document provides comprehensive information about the OSR Digital API endpoints, authentication, and usage examples.

## 🔐 Authentication

All API endpoints require authentication. Include the API token in the Authorization header:

```
Authorization: Bearer your-api-token
```

### Getting an API Token

1. Log in to the admin panel
2. Go to **Settings → API Tokens**
3. Generate a new token
4. Copy the token for use in API requests

## 📡 Base URL

```
https://your-domain.com/api
```

## 🎬 Film Portfolio API

### Get All Films
```http
GET /api/film-portfolios
```

**Query Parameters:**
- `category` (optional): Filter by category ID
- `featured` (optional): Filter featured films (true/false)
- `limit` (optional): Number of results (default: 12)

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "The Last Horizon",
      "slug": "the-last-horizon",
      "description": "A gripping sci-fi thriller...",
      "genre": "Sci-Fi Thriller",
      "year": "2024",
      "rating": "8.5",
      "duration": "2h 15m",
      "image_url": "https://example.com/image.jpg",
      "video_url": null,
      "link": null,
      "category": {
        "id": 1,
        "name": "Feature Films",
        "color": "#3B82F6"
      },
      "category_id": 1,
      "is_featured": true,
      "is_published": true,
      "views": 0,
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-15T10:00:00.000000Z"
    }
  ]
}
```

### Get Featured Films
```http
GET /api/film-portfolios/featured
```

**Query Parameters:**
- `limit` (optional): Number of results (default: 6)

### Get Films by Category
```http
GET /api/film-portfolios/category/{categoryId}
```

**Query Parameters:**
- `limit` (optional): Number of results (default: 12)

### Get Single Film
```http
GET /api/film-portfolios/{id}
```

## 🎭 Film Categories API

### Get All Categories
```http
GET /api/film-categories
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Feature Films",
      "slug": "feature-films",
      "description": "Full-length feature films and movies",
      "color": "#3B82F6",
      "is_active": true,
      "sort_order": 1,
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-15T10:00:00.000000Z"
    }
  ]
}
```

### Get Single Category
```http
GET /api/film-categories/{id}
```

## 📰 News API

### Get All News
```http
GET /api/news
```

**Query Parameters:**
- `category` (optional): Filter by category ID
- `featured` (optional): Filter featured articles (true/false)
- `limit` (optional): Number of results (default: 12)

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "OSR Digital Expands Global Distribution Network",
      "slug": "osr-digital-expands-global-distribution-network",
      "excerpt": "We are excited to announce...",
      "content": "<p>OSR Digital is proud to announce...</p>",
      "category": {
        "id": 2,
        "name": "Company Updates"
      },
      "category_id": 2,
      "is_published": true,
      "is_featured": true,
      "published_at": "2025-01-10T10:00:00.000000Z",
      "created_at": "2025-01-10T10:00:00.000000Z",
      "updated_at": "2025-01-10T10:00:00.000000Z"
    }
  ]
}
```

### Get Featured News
```http
GET /api/news/featured
```

### Get Single News Article
```http
GET /api/news/{id}
```

## 👥 Team API

### Get Team Information
```http
GET /api/team
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Leadership Team",
      "description": "Our executive leadership team...",
      "is_active": true,
      "sort_order": 1,
      "members": [
        {
          "id": 1,
          "name": "Sarah Johnson",
          "position": "CEO & Founder",
          "bio": "Sarah founded OSR Digital...",
          "team_id": 1,
          "is_active": true,
          "sort_order": 1
        }
      ]
    }
  ]
}
```

### Get Team Members
```http
GET /api/team-members
```

### Get Single Team Member
```http
GET /api/team-members/{id}
```

## 🛠️ Services API

### Get All Services
```http
GET /api/services
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Content Distribution",
      "description": "Distribute your content across multiple platforms worldwide...",
      "icon": "🌐",
      "is_active": true,
      "sort_order": 1,
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-15T10:00:00.000000Z"
    }
  ]
}
```

### Get Distribution Services
```http
GET /api/distribution-services
```

### Get Trusted Partners
```http
GET /api/trusted-partners
```

### Get Partnership Benefits
```http
GET /api/partnership-benefits
```

## 💬 Testimonials API

### Get All Testimonials
```http
GET /api/testimonials
```

**Query Parameters:**
- `featured` (optional): Filter featured testimonials (true/false)
- `limit` (optional): Number of results (default: 12)

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "John Smith",
      "position": "Independent Filmmaker",
      "content": "OSR Digital transformed our content distribution strategy...",
      "rating": 5,
      "is_featured": true,
      "is_active": true,
      "sort_order": 1,
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-15T10:00:00.000000Z"
    }
  ]
}
```

### Get Featured Testimonials
```http
GET /api/testimonials/featured
```

### Get Single Testimonial
```http
GET /api/testimonials/{id}
```

## ⚙️ Settings API

### Get Public Settings
```http
GET /api/settings
```

**Response:**
```json
{
  "success": true,
  "data": {
    "company_name": "OSR Digital",
    "contact_email": "info@osrdigital.com",
    "contact_phone": "+1 (555) 123-4567",
    "primary_color": "#EC681D",
    "facebook_url": "https://facebook.com/osrdigital",
    "twitter_url": "https://twitter.com/osrdigital",
    "linkedin_url": "https://linkedin.com/company/osrdigital"
  }
}
```

### Get Hero Sections
```http
GET /api/hero-sections
```

### Get Hero Section by Page
```http
GET /api/hero-sections/page/{page}
```

## 📄 Pages API

### Get Dynamic Pages
```http
GET /api/dynamic-pages
```

### Get Single Page
```http
GET /api/dynamic-page/{slug}
```

## 🎯 Core Values API

### Get Core Values
```http
GET /api/core-values
```

### Get Mission & Vision
```http
GET /api/mission-vision
```

## 📊 Error Responses

### 400 Bad Request
```json
{
  "success": false,
  "message": "Invalid request parameters",
  "errors": {
    "field_name": ["The field is required."]
  }
}
```

### 401 Unauthorized
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
  "success": false,
  "message": "This action is unauthorized"
}
```

### 404 Not Found
```json
{
  "success": false,
  "message": "Resource not found"
}
```

### 422 Unprocessable Entity
```json
{
  "success": false,
  "message": "The given data was invalid",
  "errors": {
    "field_name": ["The field must be a valid email."]
  }
}
```

### 500 Internal Server Error
```json
{
  "success": false,
  "message": "Internal server error"
}
```

## 🔄 Rate Limiting

API requests are rate limited to prevent abuse:

- **Authenticated requests**: 1000 requests per hour
- **Unauthenticated requests**: 100 requests per hour

Rate limit headers are included in responses:
```
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 999
X-RateLimit-Reset: 1640995200
```

## 📝 Usage Examples

### JavaScript/Fetch
```javascript
const apiUrl = 'https://your-domain.com/api';
const token = 'your-api-token';

// Get all films
fetch(`${apiUrl}/film-portfolios`, {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data));

// Get featured films
fetch(`${apiUrl}/film-portfolios/featured?limit=6`, {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data));
```

### PHP/cURL
```php
$apiUrl = 'https://your-domain.com/api';
$token = 'your-api-token';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl . '/film-portfolios');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
```

### Python/Requests
```python
import requests

api_url = 'https://your-domain.com/api'
token = 'your-api-token'

headers = {
    'Authorization': f'Bearer {token}',
    'Content-Type': 'application/json'
}

# Get all films
response = requests.get(f'{api_url}/film-portfolios', headers=headers)
data = response.json()
print(data)
```

## 🔧 SDKs and Libraries

### JavaScript/Node.js
```bash
npm install axios
```

```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'https://your-domain.com/api',
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  }
});

// Get films
const films = await api.get('/film-portfolios');
```

### PHP
```bash
composer require guzzlehttp/guzzle
```

```php
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'https://your-domain.com/api',
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'application/json'
    ]
]);

$response = $client->get('/film-portfolios');
$data = json_decode($response->getBody(), true);
```

## 📞 Support

For API support and questions:
- 📧 Email: api-support@codebundles.com
- 📖 Documentation: https://codebundles.com/docs/osr-digital/api
- 🐛 Issues: [GitHub Issues](https://github.com/your-username/osr-digital/issues)

---

**API Version**: 1.0.0  
**Last Updated**: January 15, 2025
