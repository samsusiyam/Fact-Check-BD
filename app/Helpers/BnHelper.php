<?php

namespace App\Helpers;

use Carbon\Carbon;

class BnHelper
{
    protected static array $bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    protected static array $enDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    protected static array $months = [
        'January' => 'জানুয়ারি',
        'February' => 'ফেব্রুয়ারি',
        'March' => 'মার্চ',
        'April' => 'এপ্রিল',
        'May' => 'মে',
        'June' => 'জুন',
        'July' => 'জুলাই',
        'August' => 'আগস্ট',
        'September' => 'সেপ্টেম্বর',
        'October' => 'অক্টোবর',
        'November' => 'নভেম্বর',
        'December' => 'ডিসেম্বর',
    ];

    public static function bnNum($number): string
    {
        return str_replace(self::$enDigits, self::$bnDigits, (string) $number);
    }

    public static function bnDate(?Carbon $date): string
    {
        if (!$date) return '';

        $day = self::bnNum($date->format('d'));
        $month = self::$months[$date->format('F')] ?? $date->format('F');
        $year = self::bnNum($date->format('Y'));

        return "{$day} {$month} {$year}";
    }

    public static function readingTime(string $content): string
    {
        $words = str_word_count(strip_tags($content));
        $minutes = ceil($words / 180);
        return self::bnNum($minutes ?: 1) . ' মিনিট';
    }
}
