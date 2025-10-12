<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengingat Voting</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3b82f6; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .button { display: inline-block; background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pengingat Voting</h1>
        </div>
        
        <div class="content">
            <h2>Halo {{ $user->name }}!</h2>
            
            <p>Kami ingin mengingatkan Anda bahwa voting untuk <strong>{{ $category->name }}</strong> sedang berlangsung.</p>
            
            @if($category->voting_end)
                <p><strong>Batas waktu voting:</strong> {{ $category->voting_end->format('d F Y, H:i') }}</p>
            @endif
            
            <p>Jangan lupa untuk memberikan suara Anda. Setiap suara sangat berarti untuk menentukan pemimpin yang terbaik.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('vote.categories') }}" class="button">Vote Sekarang</a>
            </div>
            
            <p>Terima kasih atas partisipasi Anda dalam proses demokrasi ini.</p>
        </div>
        
        <div class="footer">
            <p>Sistem Voting Ketua RT/RW</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>
