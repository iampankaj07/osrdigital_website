<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            border: 1px solid #e0e0e0;
            border-top: none;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .field-value {
            background: white;
            padding: 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        .message-field {
            min-height: 100px;
            white-space: pre-wrap;
        }
        .type-badge {
            display: inline-block;
            padding: 4px 8px;
            background: #667eea;
            color: white;
            border-radius: 12px;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📧 New Contact Form Submission</h1>
        <p>You have received a new message from your website</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">Name</div>
            <div class="field-value">{{ $contactData['name'] }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email Address</div>
            <div class="field-value">
                <a href="mailto:{{ $contactData['email'] }}">{{ $contactData['email'] }}</a>
            </div>
        </div>

        @if(!empty($contactData['company']))
        <div class="field">
            <div class="field-label">Company</div>
            <div class="field-value">{{ $contactData['company'] }}</div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Subject</div>
            <div class="field-value">{{ $contactData['subject'] }}</div>
        </div>

        <div class="field">
            <div class="field-label">Inquiry Type</div>
            <div class="field-value">
                <span class="type-badge">{{ ucfirst($contactData['type']) }}</span>
            </div>
        </div>

        <div class="field">
            <div class="field-label">Message</div>
            <div class="field-value message-field">{{ $contactData['message'] }}</div>
        </div>

        <div class="field">
            <div class="field-label">Submitted At</div>
            <div class="field-value">{{ now()->format('F j, Y \a\t g:i A T') }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This email was automatically generated from the OSR Digital contact form.</p>
        <p>Please reply directly to this email to respond to {{ $contactData['name'] }}.</p>
    </div>
</body>
</html>