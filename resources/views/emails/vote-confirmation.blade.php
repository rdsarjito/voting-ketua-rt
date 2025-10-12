<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Vote</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #059669; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .confirmation { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #059669; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Konfirmasi Vote</h1>
        </div>
        
        <div class="content">
            <h2>Halo {{ $user->name }}!</h2>
            
            <p>Terima kasih! Vote Anda telah berhasil direkam.</p>
            
            <div class="confirmation">
                <h3>Detail Vote Anda:</h3>
                <p><strong>Kategori:</strong> {{ $candidate->category->name }}</p>
                <p><strong>Kandidat yang dipilih:</strong> {{ $candidate->name }}</p>
                <p><strong>Waktu vote:</strong> {{ now()->format('d F Y, H:i') }}</p>
            </div>
            
            <p>Vote Anda telah tersimpan dengan aman dan akan dihitung dalam hasil akhir.</p>
            
            <p>Anda dapat melihat hasil voting setelah periode voting selesai.</p>
        </div>
        
        <div class="footer">
            <p>Sistem Voting Ketua RT/RW</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>
