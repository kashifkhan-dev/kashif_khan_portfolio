<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Response from Kashif Khan</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      width: 100% !important;
      background-color: #f8fafc;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
      color: #0f172a;
    }
    .wrapper {
      width: 100%;
      background-color: #f8fafc;
      padding: 40px 16px;
      box-sizing: border-box;
    }
    .main-card {
      max-width: 560px;
      margin: 0 auto;
      background-color: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }
    /* Top Header Profile */
    .header {
      padding: 28px 32px;
      border-bottom: 1px solid #f1f5f9;
      background-color: #ffffff;
    }
    .header-table {
      width: 100%;
    }
    .avatar-cell {
      width: 56px;
      vertical-align: top;
    }
    .avatar-wrapper {
      position: relative;
      width: 50px;
      height: 50px;
      display: inline-block;
    }
    .avatar-img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: block;
      background-color: #0f172a;
      color: #ffffff;
      text-align: center;
      line-height: 50px;
      font-weight: 800;
      font-size: 17px;
    }
    .status-dot {
      position: absolute;
      bottom: 1px;
      right: 1px;
      width: 11px;
      height: 11px;
      background-color: #10b981;
      border: 2px solid #ffffff;
      border-radius: 50%;
    }
    .header-info-cell {
      vertical-align: top;
      padding-left: 14px;
    }
    .header-name {
      font-size: 18px;
      font-weight: 800;
      color: #0f172a;
      margin: 0;
      letter-spacing: -0.02em;
    }
    .header-subtitle {
      font-size: 13px;
      color: #64748b;
      margin: 2px 0 0 0;
      font-weight: 500;
    }
    
    /* Content Body */
    .body {
      padding: 32px;
      color: #1e293b;
      font-size: 15px;
      line-height: 1.75;
    }
    .salutation {
      font-weight: 600;
      margin-bottom: 16px;
      color: #0f172a;
      font-size: 15px;
    }
    .reply-text {
      margin-bottom: 24px;
      color: #334155;
    }
    
    /* Quote Card */
    .quote-card {
      margin: 0 32px 28px 32px;
      padding: 16px 20px;
      background-color: #f8fafc;
      border: 1px solid #e2e8f0;
      border-left: 3px solid #0f172a;
      border-radius: 8px;
    }
    .quote-title {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      color: #0f172a;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }
    .quote-body {
      font-size: 13px;
      color: #64748b;
      font-style: italic;
      line-height: 1.6;
      margin: 0;
    }

    /* Button */
    .action-container {
      padding: 0 32px 32px 32px;
    }
    .btn-primary {
      display: inline-block;
      padding: 12px 24px;
      background-color: #0f172a;
      color: #ffffff !important;
      font-weight: 700;
      font-size: 13px;
      text-decoration: none;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
    }

    /* Signature Section */
    .signature-section {
      padding: 28px 32px;
      border-top: 1px solid #f1f5f9;
      background-color: #ffffff;
    }
    .signoff-greeting {
      font-size: 13px;
      color: #64748b;
      margin-bottom: 4px;
    }
    .signoff-name {
      font-size: 16px;
      font-weight: 800;
      color: #0f172a;
      margin: 0;
    }
    .signature-role {
      font-size: 13px;
      color: #4f46e5;
      font-weight: 600;
      margin-top: 2px;
    }
    .contact-meta-row {
      margin-top: 12px;
      font-size: 12px;
      color: #64748b;
    }
    .contact-meta-row span.divider {
      margin: 0 6px;
      color: #cbd5e1;
    }
    .contact-meta-row a {
      color: #475569;
      text-decoration: none;
    }

    /* Footer & Social Icons */
    .footer {
      padding: 28px 32px;
      background-color: #f8fafc;
      border-top: 1px solid #e2e8f0;
      text-align: center;
      font-size: 12px;
      color: #64748b;
    }
    .social-icon-btn {
      display: inline-block;
      width: 36px;
      height: 36px;
      line-height: 36px;
      border-radius: 50%;
      text-align: center;
      margin: 0 6px;
      text-decoration: none;
      color: #ffffff !important;
      font-size: 13px;
      font-weight: 700;
    }
    .icon-github { background-color: #0f172a; }
    .icon-linkedin { background-color: #0a66c2; }
    .icon-twitter { background-color: #1da1f2; }
    .icon-email { background-color: #6366f1; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="main-card">
      <!-- Top Header -->
      <div class="header">
        <h1 class="header-name">Kashif Khan</h1>
        <p class="header-subtitle">Full-Stack Engineer &amp; System Architect</p>
      </div>

      <!-- Main Body -->
      <div class="body">
        @if(!empty($senderName))
          <div class="salutation">Hi {{ $senderName }},</div>
        @endif

        <div class="reply-text">
          {!! nl2br(e($replyContent)) !!}
        </div>
      </div>

      @if(!empty($originalBody))
      <div class="quote-card">
        <div class="quote-title">In response to your message ({{ $originalDate }}):</div>
        <p class="quote-body">"{!! nl2br(e($originalBody)) !!}"</p>
      </div>
      @endif

      <div class="action-container">
        <a href="https://kashif-dev.42web.io" class="btn-primary" target="_blank">Visit My Portfolio &rarr;</a>
      </div>

      <!-- Executive Signature Block -->
      <div class="signature-section">
        <table cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td class="avatar-cell">
              <div class="avatar-wrapper">
                <img src="https://ui-avatars.com/api/?name=Kashif+Khan&background=0f172a&color=ffffff&size=128&font-size=0.4" alt="Kashif Khan" class="avatar-img" />
                <div class="status-dot"></div>
              </div>
            </td>
            <td class="header-info-cell">
              <div class="signoff-greeting">Best regards,</div>
              <h2 class="signoff-name">Kashif Khan</h2>
              <div class="signature-role">Full-Stack Software Engineer</div>
              
              <div class="contact-meta-row">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-right: 3px;"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                <a href="mailto:kashifkhannee@gmail.com">kashifkhannee@gmail.com</a>
                <span class="divider">|</span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-right: 3px;"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                <a href="https://kashif-dev.42web.io" target="_blank">www.kashif-dev.42web.io</a>
                <span class="divider">|</span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-right: 3px;"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                <span>Pakistan</span>
              </div>
            </td>
          </tr>
        </table>
      </div>

      <!-- Footer & Social Icons -->
      <div class="footer">
        <div style="margin-bottom: 16px;">
          <a href="https://github.com/kashifkhan-dev" class="social-icon-btn icon-github" target="_blank" title="GitHub">GH</a>
          <a href="https://linkedin.com" class="social-icon-btn icon-linkedin" target="_blank" title="LinkedIn">in</a>
          <a href="https://twitter.com" class="social-icon-btn icon-twitter" target="_blank" title="Twitter">X</a>
          <a href="mailto:kashifkhannee@gmail.com" class="social-icon-btn icon-email" title="Email">✉</a>
        </div>
        <div>&copy; {{ date('Y') }} Kashif Khan &bull; Sent in response to your portfolio inquiry.</div>
      </div>
    </div>
  </div>
</body>
</html>
