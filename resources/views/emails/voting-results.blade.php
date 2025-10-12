<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Voting</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10b981; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .results { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #10b981; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Hasil Voting Ketua RT/RW</h1>
        </div>
        
        <div class="content">
            <h2>Halo {{ $user->name }}!</h2>
            
            <p>Voting untuk pemilihan Ketua RT/RW telah selesai. Berikut adalah hasil lengkapnya:</p>
            
            @foreach($results as $result)
            <div class="results">
                <h3>{{ $result->candidate->category->name }}</h3>
                <p><strong>{{ $result->candidate->name }}</strong></p>
                <p>Total Suara: <strong>{{ $result->total }}</strong></p>
            </div>
            @endforeach
            
            <p>Terima kasih atas partisipasi Anda dalam proses demokrasi ini. Hasil ini akan digunakan untuk menentukan pemimpin yang terpilih.</p>
            
            <p>Selamat kepada para pemenang dan terima kasih kepada semua kandidat yang telah berpartisipasi.</p>
        </div>
        
        <div class="footer">
            <p>Sistem Voting Ketua RT/RW</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>
