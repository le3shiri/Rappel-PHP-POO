<?php
namespace App\Support;

// Class Str: Adat t-t3awn l-t3aml m3a l-strings
final class Str
{
    // T7awl string l-slug (mthln: "Salam PHP" -> "salam-php")
    public static function slug(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^\p{L}\p{Nd}]+/u', '-', $text);
        return trim($text, '-');
    }

    // Tqssr n-nss w tshil HTML tags
    public static function excerpt(string $content, int $max = 180): string
    {
        $clean = trim(preg_replace('/\s+/', ' ', strip_tags($content)));
        return mb_strlen($clean) <= $max ? $clean : mb_substr($clean, 0, $max - 1) . '…';
    }
}
?>