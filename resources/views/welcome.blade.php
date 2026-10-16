@extends('layouts.app')

@section('content')
    <div style="border: 1px solid var(--border-rule); background: #fff; padding: 32px; border-radius: 2px;">
        <div style="font-family: var(--font-ui); font-size: 12.5px; color: var(--accent-red); font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">
            ফেজ ১ সম্পূর্ণ — কোর ফ্রেমওয়ার্ক, রোলস ও ডাইনামিক সেটিংস সফলভাবে প্রস্তুত
        </div>
        <h1 style="font-size: 26px; margin-bottom: 16px; font-weight: 700;">
            আন্তর্জাতিক ফ্যাক্ট-চেকিং নেটওয়ার্ক (IFCN) স্ট্যান্ডার্ডে নির্মিত
        </h1>
        <p style="margin-bottom: 20px; font-size: 16px; color: #444;">
            এই সাইটের প্রতিটি টেক্সট, লোগো, নেভিগেশন মেনু, ফুটার এবং প্রাতিষ্ঠানিক পলিসিসমূহ কোনো হার্ডকোড ছাড়া সরাসরি ব্যাকএন্ড ড্যাশবোর্ড থেকে নিয়ন্ত্রণযোগ্য।
        </p>
        <div style="font-family: var(--font-ui); display: flex; gap: 12px;">
            <a href="/admin" style="background: var(--accent-red); color: #fff; padding: 10px 20px; font-size: 14px; font-weight: 600; border-radius: 2px; text-decoration: none;">
                Filament অ্যাডমিন প্যানেলে প্রবেশ করুন
            </a>
            <a href="/admin/manage-site-settings" style="border: 1px solid var(--border-rule); color: #111; padding: 10px 20px; font-size: 14px; font-weight: 600; border-radius: 2px; text-decoration: none;">
                ওয়েবসাইট সেটিংস কনফিগার করুন
            </a>
        </div>
    </div>
@endsection
