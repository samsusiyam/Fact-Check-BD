<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Page;
use App\Models\User;
use Carbon\Carbon;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        // 1. Categories
        $catPolitics = Category::firstOrCreate(['slug' => 'politics'], [
            'name_bn' => 'রাজনীতি',
            'name_en' => 'Politics',
            'order_column' => 1
        ]);
        $catHealth = Category::firstOrCreate(['slug' => 'health'], [
            'name_bn' => 'স্বাস্থ্য',
            'name_en' => 'Health',
            'order_column' => 2
        ]);
        $catAI = Category::firstOrCreate(['slug' => 'ai-deepfake'], [
            'name_bn' => 'ডিপফেক ও এআই',
            'name_en' => 'Deepfake & AI',
            'order_column' => 3
        ]);
        $catEconomy = Category::firstOrCreate(['slug' => 'economy'], [
            'name_bn' => 'অর্থনীতি',
            'name_en' => 'Economy',
            'order_column' => 4
        ]);

        // 2. Tags
        $tagPhoto = Tag::firstOrCreate(['slug' => 'photocard'], ['name_bn' => 'ফটোকার্ড', 'name_en' => 'Photocard']);
        $tagVideo = Tag::firstOrCreate(['slug' => 'video'], ['name_bn' => 'ভিডিও', 'name_en' => 'Video']);
        $tagHealth = Tag::firstOrCreate(['slug' => 'medical'], ['name_bn' => 'চিকিৎসা', 'name_en' => 'Medical']);

        // 3. Real Varied Fact-Checks
        $p1 = Post::firstOrCreate(
            ['slug' => 'lemon-warm-water-cancer-cure-claim'],
            [
                'user_id' => $user->id,
                'category_id' => $catHealth->id,
                'title_bn' => 'লেবু-গরম পানিতে ক্যান্সার সারে? না',
                'title_en' => 'Does lemon and warm water cure cancer? No',
                'excerpt_bn' => 'সামাজিক যোগাযোগমাধ্যমে ভাইরাল বার্তায় দাবি করা হয় প্রতিদিন সকালে গরম পানিতে লেবুর রস খেলে ক্যান্সার কোষ সম্পূর্ণ নির্মূল হয়। অনুসন্ধান বলছে দাবিটি বৈজ্ঞানিক ভিত্তিহীন।',
                'excerpt_en' => 'A viral health claim stating lemon and warm water cures all cancer cells is completely scientifically unfounded.',
                'claim_text_bn' => 'প্রতিদিন সকালে গরম পানির সাথে লেবুর রস খেলে ক্যান্সারের সব ধরনের কোষ ধ্বংস হয় এবং এটি কেমোথেরাপির চেয়েও কার্যকর।',
                'claim_text_en' => 'Drinking lemon juice with hot water every morning destroys cancer cells and is more effective than chemotherapy.',
                'claim_claimant_bn' => 'ফেসবুক ও হোয়াটসঅ্যাপে প্রচারিত পোস্ট',
                'claim_origin_bn' => 'Facebook / WhatsApp Group',
                'claim_date' => '১২ অক্টোবর ২০২৬',
                'verdict' => 'false',
                'verification_steps_bn' => '<p><strong>১. চিকিৎসা গবেষণার তথ্য:</strong> বিশ্ব স্বাস্থ্য সংস্থা (WHO) এবং আন্তর্জাতিক ক্যান্সার গবেষণা সংস্থা (IARC)-এর মতে লেবু স্বাস্থ্যের জন্য উপকারী হলেও এটি ক্যান্সার নিরাময় করতে পারে না।</p><p><strong>২. বিশেষজ্ঞদের অভিমত:</strong> জাতীয় ক্যান্সার গবেষণা ইনস্টিটিউটের চিকিৎসকরা জানিয়েছেন, ক্যান্সার চিকিৎসার নির্দিষ্ট বৈজ্ঞানিক প্রটোকল রয়েছে। একক কোনো খাবার ক্যান্সার সারায় না।</p>',
                'sources' => [
                    ['title' => 'World Health Organization (WHO) Cancer Guidelines', 'url' => 'https://who.int', 'type' => 'official'],
                    ['title' => 'American Cancer Society Fact Sheet', 'url' => 'https://cancer.org', 'type' => 'expert'],
                ],
                'status' => 'published',
                'published_at' => Carbon::parse('2026-10-14 10:30:00'),
                'is_lead' => true,
            ]
        );
        $p1->tags()->sync([$tagHealth->id]);

        $p2 = Post::firstOrCreate(
            ['slug' => 'asif-nazrul-prothomalo-photocard-factcheck'],
            [
                'user_id' => $user->id,
                'category_id' => $catPolitics->id,
                'title_bn' => 'আসিফ নজরুলের নামে প্রথম আলোর ফটোকার্ডটি কি আসল? না',
                'title_en' => 'Is the Prothom Alo photocard in Asif Nazrul’s name authentic? No',
                'excerpt_bn' => 'উপদেষ্টা আসিফ নজরুলের একটি মনগড়া বক্তব্য জুড়ে দিয়ে প্রথম আলোর আদলে তৈরি ভুয়া ফটোকার্ড ছড়িয়ে বিভ্রান্তি ছড়ানো হচ্ছে।',
                'excerpt_en' => 'A fabricated quote falsely attributed to adviser Asif Nazrul mimicking Prothom Alo design has gone viral.',
                'claim_text_bn' => 'আইন উপদেষ্টা আসিফ নজরুল বলেছেন: "নির্বাচন আগামী পাঁচ বছরেও সম্ভব নয়।"',
                'claim_claimant_bn' => 'ফেসবুক পেজ ও ব্যক্তিগত প্রোফাইল',
                'claim_origin_bn' => 'Facebook Pages',
                'claim_date' => '০৮ অক্টোবর ২০২৬',
                'verdict' => 'false',
                'verification_steps_bn' => '<p><strong>১. প্রথম আলোর বক্তব্য:</strong> প্রথম আলোর ডিজিটাল ডেস্ক নিশ্চিত করেছে যে তারা এমন কোনো ফটোকার্ড তৈরি বা প্রকাশ করেনি।</p><p><strong>২. ফন্ট ও ডিজাইন বিশ্লেষণ:</strong> প্রচারিত ছবিতে প্রথম আলোর মূল ফন্টের সাইজ, ট্র্যাকিং ও লোগো প্লেসমেন্টে অসঙ্গতি পাওয়া গেছে।</p>',
                'sources' => [
                    ['title' => 'প্রথম আলো অফিসিয়াল ফেসবুক পেজ যাচাই', 'url' => 'https://facebook.com/ProthomAlo', 'type' => 'official']
                ],
                'status' => 'published',
                'published_at' => Carbon::parse('2026-10-08 14:15:00'),
                'is_lead' => false,
            ]
        );
        $p2->tags()->sync([$tagPhoto->id]);

        $p3 = Post::firstOrCreate(
            ['slug' => 'erling-haaland-deepfake-video-factcheck'],
            [
                'user_id' => $user->id,
                'category_id' => $catAI->id,
                'title_bn' => 'হালান্ডের এই ভিডিওটি কি বাস্তব? না, এআই ডিপফেক',
                'title_en' => 'Is this Erling Haaland video real? No, it is an AI deepfake',
                'excerpt_bn' => 'ম্যানচেস্টার সিটির তারকা ফুটবলার আর্লিং হালান্ড ঢাকার একটি শপিং মলে শাড়ি কিনতে গেছেন—এমন দাবিতে প্রচারিত ভিডিওটি কৃত্রিম বুদ্ধিমত্তা দিয়ে তৈরি।',
                'excerpt_en' => 'A viral video claiming Erling Haaland visited a Dhaka saree store is generated by generative AI.',
                'claim_text_bn' => 'ফুটবলার আর্লিং হালান্ড গোপনে বাংলাদেশে এসে শপিং করছেন।',
                'claim_claimant_bn' => 'টিকটক ও রিলস ব্যবহারকারী',
                'claim_origin_bn' => 'TikTok / Instagram Reels',
                'claim_date' => '২৮ সেপ্টেম্বর ২০২৬',
                'verdict' => 'ai_generated',
                'verification_steps_bn' => '<p><strong>১. ডিপফেক আর্টফ্যাক্ট বিশ্লেষণ:</strong> ভিডিওতে হালান্ডের চোখের পলক না ফেলা, অডিও লিপ-সিঙ্ক মিসম্যাচ এবং আঙ্গুলের বিকৃতি নির্দেশ করে এটি হাইপার-রিয়েলিস্টিক এআই সফটওয়্যার দ্বারা তৈরি।</p>',
                'sources' => [
                    ['title' => 'Sensity AI Video Analysis Detection', 'url' => 'https://sensity.ai', 'type' => 'expert']
                ],
                'status' => 'published',
                'published_at' => Carbon::parse('2026-09-28 18:00:00'),
                'is_lead' => false,
            ]
        );
        $p3->tags()->sync([$tagVideo->id]);

        // 4. Institutional IFCN Pages
        $pages = [
            [
                'slug' => 'about',
                'title_bn' => 'আমাদের সম্পর্কে (About Us)',
                'title_en' => 'About Us',
                'content_bn' => '<h2>আমাদের পরিচিতি</h2><p>ফ্যাক্টচেক বাংলাদেশ একটি স্বাধীন ও অরাজনৈতিক তথ্যানুসন্ধান এবং ডিজিটাল ভেরিফিকেশন উদ্যোগ। আমাদের লক্ষ্য বাংলাদেশে সামাজিক মাধ্যম ও মূলধারায় ছড়িয়ে পড়া ভুল তথ্য, গুজব এবং বিকৃত কনটেন্টের সত্যতা যাচাই করে নিরপেক্ষ প্রমাণ উপস্থাপন করা।</p><h3>টিম ও নেতৃত্ব</h3><p><strong>[প্রধান সম্পাদক - নাম]:</strong> সাংবাদিকতা ও গণমাধ্যম গবেষক।<br><strong>[অনুসন্ধান সমন্বয়ক - নাম]:</strong> ওপেন সোর্স ইন্টেলিজেন্স (OSINT) বিশেষজ্ঞ।</p>',
            ],
            [
                'slug' => 'methodology',
                'title_bn' => 'অনুসন্ধান পদ্ধতি (Methodology)',
                'title_en' => 'Our Methodology',
                'content_bn' => '<h2>দাবি নির্বাচন ও রেটিং নীতিমালা</h2><p>আমরা আন্তর্জাতিক ফ্যাক্ট-চেকিং নেটওয়ার্ক (IFCN) নীতিমালা অনুযায়ী প্রতিটি দাবির প্রাথমিক উৎস এবং প্রামাণ্য দলিল বিশ্লেষণ করি।</p><h3>রেটিং ক্যাটাগরি</h3><ul><li><strong>ভুয়া (False):</strong> সম্পূর্ণ বানোয়াট ও অসত্য।</li><li><strong>বিভ্রান্তিকর (Misleading):</strong> আংশিক সত্যকে প্রেক্ষাপটহীনভাবে উপস্থাপন।</li><li><strong>ডিপফেক বা এআই (AI Generated):</strong> সিন্থেটিক মিডিয়া ও কৃত্রিম বুদ্ধিমত্তা দিয়ে তৈরি।</li><li><strong>সত্য (True):</strong> যথাযথ তথ্যপ্রমাণ দ্বারা সমর্থিত।</li><li><strong>অপ্রমাণিত (Unproven):</strong> দাবির সপক্ষে পর্যাপ্ত নির্ভরযোগ্য প্রমাণ পাওয়া যায়নি।</li></ul>',
            ],
            [
                'slug' => 'funding',
                'title_bn' => 'অর্থায়ন ও মালিকানা নীতি (Funding & Ownership)',
                'title_en' => 'Funding & Ownership',
                'content_bn' => '<h2>স্বচ্ছ অর্থায়ন প্রতিশ্রুতি</h2><p>ফ্যাক্টচেক বাংলাদেশ কোনো রাজনৈতিক দল, সরকারি সংস্থা বা কর্পোরেট স্বার্থগোষ্ঠীর কাছ থেকে অর্থায়ন গ্রহণ করে না। আমাদের পরিচালনা ব্যয় আসে উন্মুক্ত অনুদান এবং টেকনোলজি ট্রাস্ট থেকে। বিস্তারিত অডিট প্রতিবেদন নিয়মিত এই পাতায় প্রকাশ করা হয়।</p>',
            ],
            [
                'slug' => 'corrections',
                'title_bn' => 'সংশোধন নীতি (Corrections Policy)',
                'title_en' => 'Corrections Policy',
                'content_bn' => '<h2>ভুল স্বীকার ও স্বচ্ছ সংশোধন</h2><p>যদি আমাদের কোনো প্রতিবেদনে ভুল প্রমাণিত হয়, তবে আমরা তা দ্রুত এবং সম্পূর্ণ স্বচ্ছতার সাথে সংশোধন করি। সংশোধিত প্রতিটি প্রতিবেদনের শেষে স্পষ্ট "সংশোধনী নোট" যুক্ত করা হয়। পাঠকরা যেকোনো অসঙ্গতি জানাতে corrections@factcheckbd.org এ ইমেইল করতে পারেন।</p>',
            ],
            [
                'slug' => 'editorial-policy',
                'title_bn' => 'সম্পাদকীয় ও নিরপেক্ষতা নীতি (Non-Partisanship Policy)',
                'title_en' => 'Editorial & Non-Partisanship Policy',
                'content_bn' => '<h2>অরাজনৈতিক ও পক্ষপাতহীন অবস্থানের প্রতিশ্রুতি</h2><p>আমরা সব রাজনৈতিক পক্ষ ও মতাদর্শের দাবির ক্ষেত্রে সমভাবে একই ফ্যাক্ট-চেক মানদণ্ড প্রয়োগ করি। আমাদের অনুসন্ধান দলের কোনো সদস্য সক্রিয় রাজনীতিতে অংশগ্রহণ করেন না।</p>',
            ],
            [
                'slug' => 'contact',
                'title_bn' => 'যোগাযোগ (Contact)',
                'title_en' => 'Contact Us',
                'content_bn' => '<h2>আমাদের সাথে যোগাযোগের ঠিকানা</h2><p>যেকোনো অনুসন্ধান, মতামত বা সংশোধনের তথ্যের জন্য সরাসরি আমাদের সম্পাদকীয় ডেস্কে যোগাযোগ করুন।</p><p><strong>ইমেইল:</strong> contact@factcheckbd.org<br><strong>ফোন:</strong> +৮৮০ ১৭০০-০০০০০০<br><strong>ঠিকানা:</strong> ঢাকা, বাংলাদেশ।</p>',
            ],
            [
                'slug' => 'privacy',
                'title_bn' => 'গোপনীয়তা নীতি (Privacy Policy)',
                'title_en' => 'Privacy Policy',
                'content_bn' => '<h2>পাঠকের গোপনীয়তা সুরক্ষা</h2><p>ফ্যাক্টচেক বাংলাদেশ ভিজিটরদের ব্যক্তিগত তথ্যের সর্বোচ্চ নিরাপত্তা বজায় রাখে। তথ্য জমা দেওয়ার সময় প্রেরকের পরিচয় সম্পূর্ণ গোপন রাখা হয়।</p>',
            ],
        ];

        foreach ($pages as $p) {
            Page::firstOrCreate(
                ['slug' => $p['slug']],
                [
                    'title_bn' => $p['title_bn'],
                    'title_en' => $p['title_en'],
                    'content_bn' => $p['content_bn'],
                    'template' => 'default',
                    'is_active' => true,
                ]
            );
        }
    }
}
