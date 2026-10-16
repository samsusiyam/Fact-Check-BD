<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Claim Received Confirmation</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f4f2; margin: 0; padding: 25px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e2dd; border-radius: 4px; overflow: hidden;">
        <div style="background-color: #111111; color: #ffffff; padding: 18px 24px;">
            <h2 style="margin: 0; font-size: 18px; font-weight: 700; letter-spacing: 0.5px;">FACT CHECK BD</h2>
            <p style="margin: 4px 0 0; font-size: 13px; color: #aaaaaa;">স্বাধীন ও নিরপেক্ষ ফ্যাক্ট-চেকিং উদ্যোগ</p>
        </div>
        <div style="padding: 24px; color: #222222; line-height: 1.6;">
            <p style="font-size: 15px; margin-top: 0;"><strong>প্রিয় {{ $claim->submitter_name ?: 'সুধী' }},</strong></p>
            <p style="font-size: 14px;">আমাদের ফ্যাক্ট-চেক অনুসন্ধান ডেস্কে তথ্য বা গুজব যাচাইয়ের জন্য অনুরোধ পাঠানোর জন্য আপনাকে আন্তরিক ধন্যবাদ। আপনার সাবমিশনটি সফলভাবে তালিকাভুক্ত হয়েছে।</p>
            
            <div style="background-color: #fafaf8; border-left: 4px solid #0a7104; padding: 14px 18px; margin: 18px 0; font-size: 14px;">
                <p style="margin: 0 0 6px 0; font-weight: 600; color: #111111;">ট্র্যাকিং আইডি: #{{ $claim->id }}</p>
                <p style="margin: 0 0 6px 0; color: #666666; font-size: 13px;">আপনার প্রেরিত দাবি:</p>
                <div style="white-space: pre-wrap; color: #333333; font-style: italic;">“{{ Str::limit($claim->claim_text, 250) }}”</div>
            </div>

            <p style="font-size: 14px; color: #444444;">
                <strong>পরবর্তী ধাপ:</strong><br>
                আমাদের সম্পাদকীয় টিম পাবলিক ইন্টারেস্ট, ভাইরালিটি ও তথ্যের গুরুত্ব অনুসারে অনুসন্ধান কার্যক্রম পরিচালনা করে থাকে। এই দাবির সত্যতা বা অসত্যতা নিশ্চিত হওয়ার পর তা পূর্ণাঙ্গ ফ্যাক্ট-চেক রিপোর্ট আকারে আমাদের ওয়েবসাইটে প্রকাশিত হবে।
            </p>

            <p style="font-size: 14px; color: #444444; margin-bottom: 0;">
                যেকোনো সময় সরাসরি তথ্যের সত্যতা জানতে চোখ রাখুন আমাদের পোর্টালে:<br>
                <a href="{{ url('/') }}" style="color: #b3261e; font-weight: 600; text-decoration: none;">https://factcheck.hostnibo.com</a>
            </p>
        </div>
        <div style="background-color: #f8f8f6; border-top: 1px solid #e5e5e0; padding: 14px 24px; font-size: 12px; color: #777777; text-align: center;">
            FactCheck BD — সত্য উন্মোচনে আপসহীন<br>
            যেকোনো সরাসরি যোগাযোগের জন্য WhatsApp Tipline: +880 1761-844048
        </div>
    </div>
</body>
</html>
