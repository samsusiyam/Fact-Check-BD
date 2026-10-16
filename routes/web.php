<?php

use App\Helpers\BnHelper;
use App\Models\Category;
use App\Models\Claim;
use App\Models\Page;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Settings\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['bn', 'en'])) {
        session(['app_locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', function (Request $request) {
    if ($request->has('lang')) {
        session(['app_locale' => $request->get('lang')]);
    }
    app()->setLocale(session('app_locale', 'bn'));

    $leadPost = Post::published()->where('is_lead', true)->latest('published_at')->first();
    if (!$leadPost) {
        $leadPost = Post::published()->latest('published_at')->first();
    }

    $posts = Post::published()
        ->when($leadPost, fn($q) => $q->where('id', '!=', $leadPost->id))
        ->latest('published_at')
        ->paginate(10);

    $popularPosts = Post::published()->orderBy('views_count', 'desc')->take(5)->get();
    $categories = Category::all();

    return view('home', compact('leadPost', 'posts', 'categories', 'popularPosts'));
})->name('home');

// Search Route
Route::get('/search', function (Request $request) {
    if ($request->has('lang')) {
        session(['app_locale' => $request->get('lang')]);
    }
    app()->setLocale(session('app_locale', 'bn'));

    $q = trim($request->get('q', ''));
    $posts = Post::published()
        ->when($q, function ($query) use ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title_bn', 'like', "%{$q}%")
                    ->orWhere('title_en', 'like', "%{$q}%")
                    ->orWhere('claim_text_bn', 'like', "%{$q}%")
                    ->orWhere('content_bn', 'like', "%{$q}%");
            });
        })
        ->latest('published_at')
        ->paginate(12);

    $categories = Category::all();
    return view('search', compact('posts', 'q', 'categories'));
})->name('search');

Route::get('/article/{slug}', function ($slug, Request $request) {
    if ($request->has('lang')) {
        session(['app_locale' => $request->get('lang')]);
    }
    app()->setLocale(session('app_locale', 'bn'));

    $post = Post::published()->where('slug', $slug)->firstOrFail();
    $post->increment('views_count');

    // Related posts in same category
    $relatedPosts = Post::published()
        ->where('id', '!=', $post->id)
        ->where('category_id', $post->category_id)
        ->latest('published_at')
        ->take(3)
        ->get();

    return view('article', compact('post', 'relatedPosts'));
})->name('article.show');

// Photocard Download / Direct View
Route::get('/article/{slug}/card', function ($slug) {
    $post = Post::published()->where('slug', $slug)->firstOrFail();
    return view('photocard', compact('post'));
})->name('article.card');

Route::get('/page/{slug}', function ($slug, Request $request) {
    if ($request->has('lang')) {
        session(['app_locale' => $request->get('lang')]);
    }
    app()->setLocale(session('app_locale', 'bn'));

    $page = Page::published()->where('slug', $slug)->firstOrFail();
    return view('page', compact('page'));
})->name('page.show');

Route::get('/category/{slug}', function ($slug, Request $request) {
    if ($request->has('lang')) {
        session(['app_locale' => $request->get('lang')]);
    }
    app()->setLocale(session('app_locale', 'bn'));

    $category = Category::where('slug', $slug)->firstOrFail();
    $posts = $category->posts()->published()->latest('published_at')->paginate(12);
    $categories = Category::all();
    return view('category', compact('category', 'posts', 'categories'));
})->name('category.show');

Route::get('/tag/{slug}', function ($slug, Request $request) {
    if ($request->has('lang')) {
        session(['app_locale' => $request->get('lang')]);
    }
    app()->setLocale(session('app_locale', 'bn'));

    $tag = Tag::where('slug', $slug)->firstOrFail();
    $posts = $tag->posts()->published()->latest('published_at')->paginate(12);
    $categories = Category::all();
    return view('tag', compact('tag', 'posts', 'categories'));
})->name('tag.show');

// Public Claim Submission
Route::get('/submit-claim', function (Request $request) {
    if ($request->has('lang')) {
        session(['app_locale' => $request->get('lang')]);
    }
    app()->setLocale(session('app_locale', 'bn'));

    return view('submit-claim');
})->name('claim.create');

Route::post('/submit-claim', function (Request $request) {
    if (!empty($request->website_hp)) {
        return redirect()->route('claim.create')->with('success', 'তথ্য সফলভাবে জমা হয়েছে।');
    }

    $validated = $request->validate([
        'claim_text' => 'required|string|min:10|max:3000',
        'claim_url' => 'nullable|url|max:500',
        'submitter_name' => 'nullable|string|max:100',
        'submitter_email' => 'nullable|email|max:150',
        'attachment' => 'nullable|file|image|max:10240',
    ]);

    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $attachmentPath = $request->file('attachment')->store('claims', 'public');
    }

    Claim::create([
        'claim_text' => $validated['claim_text'],
        'claim_url' => $validated['claim_url'] ?? null,
        'submitter_name' => $validated['submitter_name'] ?? null,
        'submitter_email' => $validated['submitter_email'] ?? null,
        'attachment_path' => $attachmentPath,
        'ip_address' => $request->ip(),
        'status' => 'pending',
    ]);

    $lang = session('app_locale', 'bn');
    $msg = $lang === 'en' 
        ? 'Your claim has been submitted to the newsroom desk for editorial review. Thank you!'
        : 'আপনার পাঠানো দাবিটি আমাদের ফ্যাক্টচেক নিউজরুম ডেস্কে সফলভাবে জমা হয়েছে। ধন্যবাদ!';

    return redirect()->route('claim.create')->with('success', $msg);
})->name('claim.store');

// Newsletter Subscription
Route::post('/newsletter/subscribe', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email|max:150',
    ]);

    Subscriber::firstOrCreate(
        ['email' => $validated['email']],
        ['ip_address' => $request->ip(), 'subscribed_at' => now(), 'is_active' => true]
    );

    return back()->with('newsletter_success', 'ধন্যবাদ! আপনি সফলভাবে আমাদের নিয়মিত আপডেটের তালিকায় যুক্ত হয়েছেন।');
})->name('newsletter.subscribe');

// Dynamic Robots.txt
Route::get('/robots.txt', function () {
    $settings = app(SiteSettings::class);
    $content = $settings->robots_txt_content ?: "User-agent: *\nAllow: /\nSitemap: " . url('/sitemap.xml');
    return response($content, 200)->header('Content-Type', 'text/plain');
});

// Dynamic XML Sitemap
Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create();
    $sitemap->add(Url::create(url('/'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY));

    $posts = Post::published()->latest('published_at')->get();
    foreach ($posts as $post) {
        $sitemap->add(
            Url::create(route('article.show', $post->slug))
                ->setLastModificationDate($post->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
        );
    }

    $pages = Page::published()->get();
    foreach ($pages as $page) {
        $sitemap->add(
            Url::create(route('page.show', $page->slug))
                ->setLastModificationDate($page->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6)
        );
    }

    return $sitemap->toResponse(request());
});

// RSS 2.0 Feed
Route::get('/feed', function () {
    $settings = app(SiteSettings::class);
    $posts = Post::published()->latest('published_at')->take(25)->get();

    $feed = '<?xml version="1.0" encoding="UTF-8"?>';
    $feed .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
    $feed .= '<channel>';
    $feed .= '<title>' . htmlspecialchars($settings->site_name_bn) . '</title>';
    $feed .= '<link>' . url('/') . '</link>';
    $feed .= '<description>' . htmlspecialchars($settings->tagline_bn) . '</description>';
    $feed .= '<language>bn</language>';
    $feed .= '<atom:link href="' . url('/feed') . '" rel="self" type="application/rss+xml" />';

    foreach ($posts as $post) {
        $feed .= '<item>';
        $feed .= '<title>' . htmlspecialchars($post->title_bn . ' [' . $post->getVerdictLabel('bn') . ']') . '</title>';
        $feed .= '<link>' . route('article.show', $post->slug) . '</link>';
        $feed .= '<guid>' . route('article.show', $post->slug) . '</guid>';
        $feed .= '<pubDate>' . $post->published_at->toRssString() . '</pubDate>';
        $feed .= '<description><![CDATA[' . ($post->excerpt_bn ?: $post->title_bn) . ']]></description>';
        $feed .= '</item>';
    }

    $feed .= '</channel>';
    $feed .= '</rss>';

    return response($feed, 200)->header('Content-Type', 'application/xml');
});
