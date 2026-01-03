<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

class PrayerApiService
{
    protected string $baseUrl;
    protected string $latitude;
    protected string $longitude;
    protected string $timezone;

    public function __construct()
    {
        $this->baseUrl = config('services.prayer.url');
        $this->latitude = trim(config('services.prayer.latitude'));
        $this->longitude = trim(config('services.prayer.longitude'));
        $this->timezone = config('services.prayer.timezone', 'UTC');
    }

    /**
     * Get weekly prayer schedule for the week containing $forDate (Carbon, timezone aware).
     * Returns array of prayer rows: [ ['prayer_name' => 'Subuh', 'monday' => '04:32', ...], ... ]
     */
    public function getWeeklySchedule(Carbon $forDate = null): array
    {
        $tz = $this->timezone;
        $date = $forDate ? $forDate->copy()->setTimezone($tz) : Carbon::now($tz);
        $weekStart = $date->copy()->startOfWeek(); // Monday

        // Collect month/year combos we need to fetch
        $needed = [];
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $d = $weekStart->copy()->addDays($i);
            $days[] = $d;
            $needed[$d->format('Y-m')] = ['month' => $d->month, 'year' => $d->year];
        }

        $calendar = [];
        foreach ($needed as $ny) {
            $url = rtrim($this->baseUrl, '/') . '/calendar';
            $res = Http::get($url, [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'method' => 2,
                'month' => $ny['month'],
                'year' => $ny['year'],
            ]);

            if (!$res->ok()) {
                \Illuminate\Support\Facades\Log::error("Prayer API request failed: {$url} (HTTP {$res->status()})");
                continue;
            }

            $data = $res->json('data', []);
            if (empty($data)) {
                \Illuminate\Support\Facades\Log::warning("Prayer API returned empty data for month {$ny['month']}/{$ny['year']}");
            }

            foreach ($data as $item) {
                $dateStr = $item['date']['gregorian']['date'] ?? null; // format dd-mm-yyyy
                if ($dateStr) {
                    // normalize to Y-m-d
                    $parts = explode('-', $dateStr);
                    if (count($parts) === 3) {
                        [$d, $m, $y] = $parts;
                        $key = sprintf('%04d-%02d-%02d', $y, $m, $d);
                        $calendar[$key] = $item['timings'] ?? [];
                    }
                }
            }
        }

        // Map prayer keys from provider to Indonesian names used in app
        $mapping = [
            'Fajr' => 'Subuh',
            'Dhuhr' => 'Dzuhur',
            'Asr' => 'Ashar',
            'Maghrib' => 'Maghrib',
            'Isha' => 'Isya',
        ];

        // Initialize rows
        $rows = [];
        foreach ($mapping as $key => $label) {
            $rows[$label] = [
                'prayer_name' => $label,
                'monday' => null,
                'tuesday' => null,
                'wednesday' => null,
                'thursday' => null,
                'friday' => null,
                'saturday' => null,
                'sunday' => null,
            ];
        }

        // Fill times
        foreach ($days as $idx => $day) {
            $dayKey = $day->format('Y-m-d');
            $dayName = strtolower($day->format('l')); // monday, tuesday, ...
            $timings = $calendar[$dayKey] ?? [];
            foreach ($mapping as $apiKey => $label) {
                $raw = Arr::get($timings, $apiKey, '');
                // Extract HH:MM from raw string (e.g. "04:36 (WIB)")
                if (preg_match('/(\d{1,2}:\d{2})/', $raw, $m)) {
                    $time = $m[1];
                } else {
                    $time = null;
                }
                $rows[$label][$dayName] = $time;
            }
        }

        // Return as numeric array
        return array_values($rows);
    }
}
