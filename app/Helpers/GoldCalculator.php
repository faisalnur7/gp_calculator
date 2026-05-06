<?php

namespace App\Helpers;

class GoldCalculator
{
    // Gram conversions (Bangladesh standard)
    const GRAMS_PER_VORI  = 11.664;
    const GRAMS_PER_ANA   = 0.729;    // 11.664 / 16
    const GRAMS_PER_ROTI  = 0.1215;   // 0.729  / 6
    const GRAMS_PER_POINT = 0.01215;  // 0.1215 / 10

    // Unit relationships: 1 Vori = 16 Ana, 1 Ana = 6 Roti, 1 Roti = 10 Point
    const ANA_PER_VORI    = 16;
    const ROTI_PER_ANA    = 6;
    const POINT_PER_ROTI  = 10;

    // Point equivalents: 1 Vori = 960 points
    const POINTS_PER_VORI = 960;  // 16 * 6 * 10
    const POINTS_PER_ANA  = 60;   // 6  * 10
    const POINTS_PER_ROTI = 10;

    /** Convert Vori/Ana/Roti/Point → total points */
    public static function toPoint(int $vori, int $ana, int $roti, int $point): int
    {
        return ($vori * self::POINTS_PER_VORI)
             + ($ana  * self::POINTS_PER_ANA)
             + ($roti * self::POINTS_PER_ROTI)
             + $point;
    }

    /** Convert total points → Vori/Ana/Roti/Point */
    public static function fromPoint(int $totalPoints): array
    {
        $vori = intdiv($totalPoints, self::POINTS_PER_VORI);
        $rem  = $totalPoints % self::POINTS_PER_VORI;

        $ana  = intdiv($rem, self::POINTS_PER_ANA);
        $rem  = $rem % self::POINTS_PER_ANA;

        $roti  = intdiv($rem, self::POINTS_PER_ROTI);
        $point = $rem % self::POINTS_PER_ROTI;

        return compact('vori', 'ana', 'roti', 'point');
    }

    /** Convert Vori/Ana/Roti/Point → grams */
    public static function toGrams(int $vori, int $ana, int $roti, int $point): float
    {
        return round(
            ($vori * self::GRAMS_PER_VORI)
          + ($ana  * self::GRAMS_PER_ANA)
          + ($roti * self::GRAMS_PER_ROTI)
          + ($point * self::GRAMS_PER_POINT),
            4
        );
    }

    /** Format weight as readable string e.g. "2v 5a 3r 7p" */
    public static function format(int $vori, int $ana, int $roti, int $point): string
    {
        $parts = [];
        if ($vori)  $parts[] = "{$vori}v";
        if ($ana)   $parts[] = "{$ana}a";
        if ($roti)  $parts[] = "{$roti}r";
        $parts[] = "{$point}p";
        return implode(' ', $parts);
    }

    /** Validate unit ranges: Ana < 16, Roti < 6, Point < 10 */
    public static function validate(int $ana, int $roti, int $point): array
    {
        $errors = [];
        if ($ana  >= self::ANA_PER_VORI)   $errors[] = 'Ana must be less than 16 (0–15).';
        if ($roti >= self::ROTI_PER_ANA)   $errors[] = 'Roti must be less than 6 (0–5).';
        if ($point >= self::POINT_PER_ROTI) $errors[] = 'Point must be less than 10 (0–9).';
        return $errors;
    }
}
