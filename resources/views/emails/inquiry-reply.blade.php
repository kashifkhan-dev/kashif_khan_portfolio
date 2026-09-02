<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Response to your inquiry</title>
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #0a0a0a;
      color: #e5e5e5;
      margin: 0;
      padding: 30px 15px;
    }
    .email-card {
      max-width: 600px;
      margin: 0 auto;
      background-color: #121212;
      border: 1px solid #262626;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }
    .header {
      padding: 24px 30px;
      background-color: #171717;
      border-bottom: 1px solid #262626;
    }
    .header h2 {
      margin: 0;
      color: #ffffff;
      font-size: 18px;
      font-weight: 700;
      letter-spacing: -0.02em;
    }
    .header p {
      margin: 4px 0 0 0;
      color: #a3a3a3;
      font-size: 12px;
    }
    .body-content {
      padding: 30px;
      color: #d4d4d4;
      font-size: 14px;
      line-height: 1.6;
      white-space: pre-wrap;
    }
    .quote-box {
      margin: 25px 30px 30px 30px;
      padding: 16px 20px;
      background-color: #18181b;
      border-left: 3px solid #6366f1;
      border-radius: 4px;
    }
    .quote-title {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      color: #818cf8;
      letter-spacing: 0.05em;
      margin-bottom: 8px;
    }
    .quote-text {
      font-size: 13px;
      color: #a1a1aa;
      font-style: italic;
      margin: 0;
      white-space: pre-wrap;
    }
    .footer {
      padding: 20px 30px;
      background-color: #171717;
      border-top: 1px solid #262626;
      font-size: 11px;
      color: #737373;
      text-align: center;
    }
    .footer a {
      color: #818cf8;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="email-card">
    <div class="header">
      <h2>Kashif Khan</h2>
      <p>Full-Stack Engineer &amp; System Architect</p>
    </div>

    <div class="body-content">
{{ $replyContent }}
    </div>

    <div class="quote-box">
      <div class="quote-title">In Response To Your Message ({{ $originalDate }}):</div>
      <p class="quote-text">{{ $originalBody }}</p>
    </div>

    <div class="footer">
      Sent from <a href="https://kashifkhan.dev">Kashif Khan Portfolio</a> &bull; Response to inquiry: {{ $originalSubject ?? 'Inquiry' }}
    </div>
  </div>
</body>
</html>
