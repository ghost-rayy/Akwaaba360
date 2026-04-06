<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f7f7; color: #333; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(90deg, #FF8D4D 0%, #FF6B35 100%); padding: 40px; text-align: center; color: white; }
        .logo { background-color: #ffffff; width: 60px; height: 60px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 900; color: #FF8D4D; margin-bottom: 20px; }
        .content { padding: 40px; line-height: 1.6; }
        h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px; }
        p { font-size: 16px; margin: 15px 0; }
        .credential-box { background-color: #fff8f5; border: 1px solid #ffe8e0; border-radius: 12px; padding: 25px; margin: 30px 0; }
        .credential-item { margin: 10px 0; font-size: 14px; color: #666; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .credential-value { font-size: 20px; color: #FF6B35; font-weight: 800; }
        .cta-button { display: inline-block; background-color: #FF6B35; color: #ffffff !important; padding: 18px 36px; border-radius: 12px; font-weight: 800; text-decoration: none; margin-top: 30px; text-align: center; }
        .footer { padding: 30px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #f0f0f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">A</div>
            <h1>Welcome to Akwaaba360</h1>
            <p style="margin: 5px 0 0; opacity: 0.8; font-weight: 500;">
                @if($user->role == 'hr_staff')
                    Administrative Access Authorization
                @else
                    National Service Personnel Onboarding
                @endif
            </p>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $user->name }}</strong>,</p>
            @if($user->role == 'hr_staff')
                <p>Congratulations! You have been authorized as an **HR Staff** member with {{ config('app.name') }}. Your administrative account is now active and ready for use.</p>
            @else
                <p>Congratulations! You have been onboarded for your National Service with {{ config('app.name') }}. Your account is now active and ready for the next phase of your recruitment journey.</p>
            @endif
            
            <div class="credential-box">
                <div class="credential-item">Email Address</div>
                <div class="credential-value" style="font-size: 16px; margin-bottom: 15px;">{{ $user->email }}</div>
                
                <div class="credential-item">Temporary Password</div>
                <div class="credential-value">{{ $tempPassword }}</div>
            </div>
            
            <p style="color: #666; font-size: 14px;">Please note that for security reasons, you will be required to change this password upon your first login.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="cta-button">Access Your Portal</a>
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Akwaaba360 HR Suite. All rights reserved.<br>
            Accra, Ghana</p>
        </div>
    </div>
</body>
</html>
