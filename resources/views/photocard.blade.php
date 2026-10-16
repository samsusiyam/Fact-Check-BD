<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>ফটোকার্ড — {{ $post->title_bn }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@500;700&family=Noto+Serif+Bengali:wght@700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #222;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Noto Sans Bengali', sans-serif;
            padding: 20px;
        }
        .card-container {
            width: 800px;
            height: 800px;
            background: #FAFAF7;
            border: 2px solid #111;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #111;
            padding-bottom: 16px;
        }
        .card-brand {
            font-size: 24px;
            font-weight: 700;
            font-family: 'Noto Serif Bengali', serif;
            letter-spacing: -0.02em;
        }
        .verdict-stamp {
            background: #B3261E;
            color: #FFF;
            padding: 6px 18px;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 2px;
        }
        .card-body {
            margin: auto 0;
        }
        .claim-badge {
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 700;
            color: #777;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }
        .headline {
            font-size: 38px;
            font-weight: 700;
            font-family: 'Noto Serif Bengali', serif;
            line-height: 1.35;
            color: #111;
            margin-bottom: 20px;
        }
        .claim-quote {
            background: #FFF;
            border-left: 4px solid #B3261E;
            padding: 16px 20px;
            font-size: 20px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        .card-footer {
            border-top: 1px solid #E5E5E0;
            padding-top: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card-header">
            <div class="card-brand">ফ্যাক্টচেক বাংলাদেশ</div>
            <div class="verdict-stamp">{{ $post->getVerdictLabel('bn') }}</div>
        </div>

        <div class="card-body">
            <div class="claim-badge">যাচাইকৃত দাবি:</div>
            <div class="claim-quote">"{{ $post->claim_text_bn }}"</div>
            <h1 class="headline">{{ $post->title_bn }}</h1>
        </div>

        <div class="card-footer">
            <div>উৎস: {{ $post->claim_claimant_bn ?: 'সামাজিক যোগাযোগমাধ্যম' }}</div>
            <div>বিস্তারিত পড়ুন: <strong>factcheck.hostnibo.com</strong></div>
        </div>
    </div>
</body>
</html>
