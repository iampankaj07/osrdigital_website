<?php
/**
 * Domain Redirect Script
 * Redirects main domain to subdomain for shared hosting
 */

// Target subdomain URL
$target_url = 'https://osr.codebundles.com';

// Get the current request URI
$request_uri = $_SERVER['REQUEST_URI'] ?? '/';

// Preserve query parameters
$query_string = $_SERVER['QUERY_STRING'] ?? '';
if ($query_string) {
    $target_url .= $request_uri . '?' . $query_string;
} else {
    $target_url .= $request_uri;
}

// Set proper headers
header('HTTP/1.1 301 Moved Permanently');
header('Location: ' . $target_url);
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Output a simple redirect page as fallback
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to OSR Digital...</title>
    <meta http-equiv="refresh" content="0; url=<?php echo htmlspecialchars($target_url); ?>">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: white;
        }
        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #EC681D;
        }
        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #EC681D;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .message {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        .link {
            color: #EC681D;
            text-decoration: none;
            font-weight: bold;
        }
        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">OSR Digital</div>
        <div class="spinner"></div>
        <div class="message">Redirecting to our main site...</div>
        <div>If you are not redirected automatically, <a href="<?php echo htmlspecialchars($target_url); ?>" class="link">click here</a>.</div>
    </div>

    <script>
        // Immediate redirect
        window.location.replace('<?php echo htmlspecialchars($target_url); ?>');
        
        // Fallback redirect after 3 seconds
        setTimeout(function() {
            window.location.href = '<?php echo htmlspecialchars($target_url); ?>';
        }, 3000);
    </script>
</body>
</html>
