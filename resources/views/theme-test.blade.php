<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme Settings Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: #f8f9fa; padding: 20px; margin: 10px 0; border-radius: 8px; }
        .logo { max-height: 100px; }
        .color-box { width: 50px; height: 50px; display: inline-block; margin: 10px; border: 1px solid #ccc; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 4px; overflow: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Theme Settings Frontend Test</h1>

        <div class="card">
            <h2>Company Information</h2>
            <p><strong>Name:</strong> {{ $settings['site_name'] ?? 'N/A' }}</p>
            <p><strong>Tagline:</strong> {{ $settings['site_tagline'] ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $settings['support_email'] ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $settings['support_phone'] ?? 'N/A' }}</p>
        </div>

        <div class="card">
            <h2>Branding</h2>
            @if(isset($settings['logo']) && $settings['logo'])
                <p><strong>Logo:</strong></p>
                <img src="{{ $settings['logo'] }}" alt="Logo" class="logo">
            @else
                <p><strong>Logo:</strong> Not set</p>
            @endif

            @if(isset($settings['theme_color']) && $settings['theme_color'])
                <p><strong>Theme Color:</strong> {{ $settings['theme_color'] }}</p>
                <div class="color-box" style="background-color: {{ $settings['theme_color'] }}"></div>
            @endif
        </div>

        <div class="card">
            <h2>Social Media</h2>
            @if(isset($settings['social']['facebook']))
                <p><strong>Facebook:</strong> {{ $settings['social']['facebook'] }}</p>
            @endif
            @if(isset($settings['social']['twitter']))
                <p><strong>Twitter:</strong> {{ $settings['social']['twitter'] }}</p>
            @endif
            @if(isset($settings['social']['linkedin']))
                <p><strong>LinkedIn:</strong> {{ $settings['social']['linkedin'] }}</p>
            @endif
        </div>

        <div class="card">
            <h2>All Settings (JSON)</h2>
            <pre>{{ json_encode($settings['all'] ?? [], JSON_PRETTY_PRINT) }}</pre>
        </div>

        <div class="card">
            <h2>API Test</h2>
            <p>Test the API endpoints:</p>
            <ul>
                <li><a href="/api/settings" target="_blank">/api/settings</a> - All settings grouped</li>
                <li><a href="/api/settings/flat" target="_blank">/api/settings/flat</a> - Flat settings</li>
                <li><a href="/api/settings/theme" target="_blank">/api/settings/theme</a> - Theme-specific settings</li>
                <li><a href="/api/settings/group/branding" target="_blank">/api/settings/group/branding</a> - Branding settings</li>
            </ul>
        </div>
    </div>
</body>
</html>
