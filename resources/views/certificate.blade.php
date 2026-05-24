<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificates</title>
  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: #f9f9fb;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 1000px;
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
      overflow: hidden;
    }
    .header {
      background: #e60000;
      color: #fff;
      padding: 40px;
      text-align: center;
    }
    .header h1 {
      margin: 0;
      font-size: 2rem;
      font-weight: 700;
    }
    .header p {
      margin-top: 8px;
      font-size: 1rem;
      color: #ffe5e5;
    }
    .body {
      padding: 40px;
    }
    .certificate-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 24px;
    }
    .certificate-card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .certificate-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .certificate-card h3 {
      margin: 0 0 12px;
      font-size: 1.25rem;
      color: #e60000;
    }
    .certificate-card p {
      margin: 6px 0;
      font-size: 0.95rem;
      line-height: 1.5;
    }
    .certificate-actions {
      margin-top: 16px;
    }
    .btn {
      display: inline-block;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 600;
      text-decoration: none;
      margin-right: 8px;
      transition: background 0.2s ease;
    }
    .btn-view {
      background: #e60000;
      color: #fff;
    }
    .btn-view:hover {
      background: #b30000;
    }
    .btn-download {
      background: #4CAF50;
      color: #fff;
    }
    .btn-download:hover {
      background: #3e8e41;
    }
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #666;
      font-size: 1.1rem;
    }
    .button-wrap {
      text-align: center;
      margin-top: 40px;
    }
    .back-btn {
      background: #e60000;
      border: none;
      color: #fff;
      padding: 14px 28px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1rem;
      font-weight: 600;
      transition: background 0.2s ease;
    }
    .back-btn:hover {
      background: #b30000;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Your Certificates</h1>
      <p>Review and download your earned certificates below.</p>
    </div>
    <div class="body">
      @if (!empty($certificates) && $certificates->count() > 0)
        <div class="certificate-list">
          @foreach ($certificates as $certificate)
            <div class="certificate-card">
              <h3>{{ $certificate->course_name }}</h3>
              <p><strong>Student:</strong> {{ $first }} {{ $last }}</p>
              <p><strong>Username:</strong> {{ $username }}</p>
              <p><strong>Score:</strong> {{ $certificate->score ?? 0 }} / 50</p>
              <p><strong>Percentage:</strong> {{ number_format($certificate->percentage ?? 0, 2) }}%</p>
              <p><strong>Passed:</strong> {{ $certificate->passed ? 'Yes' : 'No' }}</p>
              <p><strong>Awarded:</strong> {{ optional($certificate->awarded_at)->format('F j, Y \a\t g:i A') }}</p>
              <div class="certificate-actions">
                <a href="{{ route('certificate.view', ['certificateId' => $certificate->id]) }}" class="btn btn-view" target="_blank">👁️ View</a>
                <a href="{{ route('certificate.download', ['certificateId' => $certificate->id]) }}" class="btn btn-download" download>📥 Download</a>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-state">
          <p>You have no certificates yet.</p>
          <p>Complete a course and pass the final exam to earn one.</p>
        </div>
      @endif

      <div class="button-wrap">
        <a href="{{ route('dashboard') }}"><button class="back-btn">⬅ Back to Dashboard</button></a>
      </div>
    </div>
  </div>
</body>
</html>
