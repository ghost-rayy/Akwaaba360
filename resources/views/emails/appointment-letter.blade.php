<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f7f7; color: #333; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { background: #FF6B35; padding: 40px; text-align: center; color: white; }
        .content { padding: 40px; line-height: 1.6; }
        h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px; }
        p { font-size: 16px; margin: 15px 0; }
        .letter-box { background-color: #fcfcfc; border: 1px solid #f0f0f0; border-radius: 12px; padding: 30px; margin: 30px 0; }
        .cta-button { display: inline-block; background-color: #FF6B35; color: #ffffff !important; padding: 18px 36px; border-radius: 12px; font-weight: 800; text-decoration: none; margin-top: 30px; text-align: center; }
        .footer { padding: 30px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #f0f0f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Appointment Notification</h1>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $user->name }}</strong>,</p>
            <p>We are pleased to inform you that your recruitment process for National Service with <strong>{{ $settings->company_name ?? 'Akwaaba360' }}</strong> has been finalized. You have been officially appointed to your designated role.</p>
            
            <div class="letter-box">
                <p style="font-size: 14px; color: #666; margin-bottom: 5px;">Organizational Unit:</p>
                <p style="font-size: 18px; font-weight: 800; color: #333; margin-top: 0;">{{ $user->department->name ?? 'Service Operations' }}</p>
                
                <p style="font-size: 14px; color: #666; margin-bottom: 5px; margin-top: 20px;">Position Status:</p>
                <p style="font-size: 18px; font-weight: 800; color: #FF6B35; margin-top: 0;">Confirmed Appointment</p>
            </div>
            
            <p>Your official appointment letter is now available in your personnel portal. Please log in to view and download your documentation.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="cta-button">View Appointment Letter</a>
            </div>
            
            <p style="margin-top: 40px; font-size: 14px; color: #999;">Best regards,<br>
            <strong>HR Administration</strong><br>
            {{ $settings->company_name ?? 'Akwaaba360' }} Team</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Akwaaba360 Institutional Service. All rights reserved.<br>
            {{ $settings->po_box ?? 'Accra, Ghana' }}</p>
        </div>
    </div>
</body>
</html>
