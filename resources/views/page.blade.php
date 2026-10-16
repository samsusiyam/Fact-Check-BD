@extends('layouts.app')

@section('content')
    @php
        $title = $page->title_bn;
        $content = $page->content_bn;
    @endphp

    <div class="page-container" style="max-width: {{ $page->template === 'full-width' ? '1080px' : '780px' }}; margin: 0 auto; width: 100%; box-sizing: border-box; padding: 10px 0;">
        <h1 style="font-size: 26px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid var(--border-rule); padding-bottom: 12px; word-break: break-word;">
            {{ $title }}
        </h1>

        <div class="page-content" style="line-height: 1.85; font-size: 16px; word-break: break-word; overflow-wrap: break-word;">
            {!! $content !!}
        </div>
    </div>
@endsection
