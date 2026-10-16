<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>New Claim Submitted</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f4f2; margin: 0; padding: 25px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e2dd; border-radius: 4px; overflow: hidden;">
        <div style="background-color: #111111; color: #ffffff; padding: 18px 24px;">
            <h2 style="margin: 0; font-size: 18px; font-weight: 700; letter-spacing: 0.5px;">FACT CHECK BD — NEWSROOM DESK</h2>
            <p style="margin: 4px 0 0; font-size: 13px; color: #aaaaaa;">নতুন ক্লেইম/গুজব ভেরিফিকেশন রিকোয়েস্ট (#{{ $claim->id }})</p>
        </div>
        <div style="padding: 24px; color: #222222; line-height: 1.6;">
            <p style="font-size: 15px; margin-top: 0;"><strong>প্রিয় এডিটর,</strong></p>
            <p style="font-size: 14px;">পাবলিক টিপলাইন ও ক্লেইম ফর্মের মাধ্যমে একটি নতুন ফ্যাক্ট-চেক অনুসন্ধানের অনুরোধ জমা হয়েছে:</p>
            
            <div style="background-color: #fafaf8; border-left: 4px solid #b3261e; padding: 14px 18px; margin: 18px 0; font-size: 14px;">
                <p style="margin: 0 0 8px 0;"><strong>দাবি / ক্লেইম বিবরণ:</strong></p>
                <div style="white-space: pre-wrap; color: #333333;">{{ $claim->claim_text }}</div>
            </div>

            <table style="width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 6px 0; color: #666666; width: 140px;">সাবমিটার নাম:</td>
                    <td style="padding: 6px 0; font-weight: 600;">{{ $claim->submitter_name ?: 'নাম প্রকাশে অনিচ্ছুক (Anonymous)' }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #666666;">সাবমিটার ইমেইল:</td>
                    <td style="padding: 6px 0; font-weight: 600;">{{ $claim->submitter_email ?: 'ইমেইল দেওয়া হয়নি' }}</td>
                </tr>
                @if($claim->claim_url)
                <tr>
                    <td style="padding: 6px 0; color: #666666;">রেফারেন্স লিংক:</td>
                    <td style="padding: 6px 0;"><a href="{{ $claim->claim_url }}" target="_blank" style="color: #b3261e; word-break: break-all;">{{ $claim->claim_url }}</a></td>
                </tr>
                @endif
                @if($claim->attachment_path)
                <tr>
                    <td style="padding: 6px 0; color: #666666;">সংযুক্ত প্রমাণ/ছবি:</td>
                    <td style="padding: 6px 0;"><a href="{{ asset('storage/' . $claim->attachment_path) }}" target="_blank" style="color: #0b6623; font-weight: 600;">সংযুক্তি দেখুন / ডাউনলোড</a></td>
                </tr>
                @endif
                <tr>
                    <td style="padding: 6px 0; color: #666666;">জমার সময়:</td>
                    <td style="padding: 6px 0;">{{ $claim->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{ url('/admin/claims/' . $claim->id . '/edit') }}" style="background-color: #b3261e; color: #ffffff; text-decoration: none; padding: 10px 22px; font-size: 14px; font-weight: 600; border-radius: 2px; display: inline-block;">অ্যাডমিন প্যানেলে ক্লেইমটি ওপেন করুন →</a>
            </div>
        </div>
        <div style="background-color: #f8f8f6; border-top: 1px solid #e5e5e0; padding: 12px 24px; font-size: 12px; color: #777777; text-align: center;">
            FactCheck BD Newsroom Notification System
        </div>
    </div>
</body>
</html>
