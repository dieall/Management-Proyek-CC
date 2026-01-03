<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use App\Models\WeeklyPrayerSchedule;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasjidController extends Controller
{
    /**
     * Show the home page with articles and prayer schedules
     */
    public function index(Request $request)
    {
        $query = Article::where('is_active', true);

        // Date filters (day, month, year) applied to `created_at`
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        if ($day) {
            $query->whereDay('created_at', $day);
        }
        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        // Order by newest upload first, then by configured order
        $articles = $query->orderBy('created_at', 'desc')
            ->orderBy('order')
            ->get();
        
        $prayerSchedules = WeeklyPrayerSchedule::all();
        $masjid = Masjid::first();

        // Prepare month names and available years for filters
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $availableYears = Article::selectRaw('YEAR(created_at) as year')
            ->orderByDesc('year')
            ->pluck('year')
            ->unique()
            ->toArray();

        return view('masjid.index', [
            'articles' => $articles,
            'prayerSchedules' => $prayerSchedules,
            'masjid' => $masjid,
            'selectedDay' => $day,
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'months' => $months,
            'availableYears' => $availableYears,
        ]);
    }

    /**
     * Show the admin edit page
     */
    public function edit()
    {
        $masjid = Masjid::first();
        $articles = Article::orderBy('order')->orderBy('created_at', 'desc')->get();
        $prayerSchedules = WeeklyPrayerSchedule::all();
        
        return view('masjid.edit', [
            'masjid' => $masjid,
            'articles' => $articles,
            'prayerSchedules' => $prayerSchedules
        ]);
    }

    /**
     * Update masjid information
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        $masjid = Masjid::first();
        
        if (!$masjid) {
            $masjid = new Masjid();
        }
        
        $masjid->update($validated);

        return redirect()->route('masjid.edit')->with('success', 'Informasi masjid berhasil diperbarui!');
    }

    /**
     * Add article
     */
    public function addArticle(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'link_url' => 'nullable|string',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_active' => true,
            'order' => Article::max('order') + 1,
            'link_url' => $validated['link_url'] ?? null,
        ];

        // Handle file upload (preferred)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $data['image_url'] = Storage::url($path);
        } elseif (!empty($validated['image_url'] ?? null)) {
            // Use provided external image URL if file not uploaded
            $data['image_url'] = $validated['image_url'];
        }

        Article::create($data);

        return redirect()->route('masjid.edit')->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Update article
     */
    public function updateArticle(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'link_url' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'link_url' => $validated['link_url'] ?? null,
            'is_active' => $validated['is_active'] ?? false,
        ];

        // Handle new uploaded image (preferred)
        if ($request->hasFile('image')) {
            // delete old stored image if it exists and is in storage
            if ($article->image_url && str_starts_with($article->image_url, Storage::url(''))) {
                $oldPath = ltrim(str_replace(Storage::url(''), '', $article->image_url), '/');
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('articles', 'public');
            $data['image_url'] = Storage::url($path);
        } elseif (!empty($validated['image_url'] ?? null)) {
            // switching to external URL; if previous image was stored, delete the stored file
            if ($article->image_url && str_starts_with($article->image_url, Storage::url(''))) {
                $oldPath = ltrim(str_replace(Storage::url(''), '', $article->image_url), '/');
                Storage::disk('public')->delete($oldPath);
            }

            $data['image_url'] = $validated['image_url'];
        }

        $article->update($data);

        return redirect()->route('masjid.edit')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Delete article
     */
    public function deleteArticle(Article $article)
    {
        $article->delete();

        return redirect()->route('masjid.edit')->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * Add prayer schedule
     * (Disabled) - admin panel tidak lagi menerima penambahan jadwal
     */
    public function addPrayer(Request $request)
    {
        return redirect()->route('masjid.edit')->with('error', 'Penambahan jadwal shalat dinonaktifkan.');
    }

    /**
     * Update prayer schedule
     * (Disabled) - admin panel tidak lagi menerima perubahan jadwal
     */
    public function updatePrayer(Request $request, WeeklyPrayerSchedule $prayerSchedule)
    {
        return redirect()->route('masjid.edit')->with('error', 'Pengubahan jadwal shalat dinonaktifkan.');
    }

    /**
     * Delete prayer schedule
     * (Disabled) - admin panel tidak lagi menerima penghapusan jadwal
     */
    public function deletePrayer(WeeklyPrayerSchedule $prayerSchedule)
    {
        return redirect()->route('masjid.edit')->with('error', 'Penghapusan jadwal shalat dinonaktifkan.');
    }
}

