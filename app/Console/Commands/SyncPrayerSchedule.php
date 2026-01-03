<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PrayerApiService;
use App\Models\WeeklyPrayerSchedule;
use Illuminate\Support\Facades\Log;

class SyncPrayerSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prayer:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync weekly prayer schedule from external API (Bandung)';

    public function handle(PrayerApiService $service)
    {
        $this->info('Fetching weekly prayer schedule...');
        try {
            $schedules = $service->getWeeklySchedule();
            foreach ($schedules as $row) {
                $prayerName = $row['prayer_name'];
                $data = $row;
                unset($data['prayer_name']);

                // Only update fields that are not null (avoid overwriting with null)
                $updateData = array_filter($data, function ($v) {
                    return !is_null($v) && $v !== '';
                });

                $existing = WeeklyPrayerSchedule::where('prayer_name', $prayerName)->first();

                if ($existing) {
                    if (!empty($updateData)) {
                        // Normalize update times to HH:MM (trim seconds if present)
                        foreach ($updateData as $k => $v) {
                            if (preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $v)) {
                                $parts = explode(':', $v);
                                $updateData[$k] = sprintf('%02d:%02d', $parts[0], $parts[1]);
                            }
                        }

                        $existing->update($updateData);
                        $this->info("Updated: {$prayerName}");
                    } else {
                        $this->info("No valid times for: {$prayerName}, skipped update.");
                    }
                } else {
                    // For creation we need all days to be present (DB columns are non-nullable)
                    $missing = array_filter($data, function ($v) {
                        return is_null($v) || $v === '';
                    });

                    if (!empty($missing)) {
                        Log::warning("Skipped creating {$prayerName} because response missing some times.");
                        $this->warn("Skipped creating {$prayerName} due to incomplete data.");
                        continue;
                    }

                    // Normalize times to HH:MM
                    $createData = [];
                    foreach ($data as $k => $v) {
                        if (preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $v)) {
                            $parts = explode(':', $v);
                            $createData[$k] = sprintf('%02d:%02d', $parts[0], $parts[1]);
                        } else {
                            $createData[$k] = $v;
                        }
                    }

                    // Include prayer_name when creating record
                    $createData = array_merge(['prayer_name' => $prayerName], $createData);

                    WeeklyPrayerSchedule::create($createData);
                    $this->info("Created: {$prayerName}");
                }
            }

            $this->info('Prayer schedule synced successfully.');
            return 0;
        } catch (\Exception $e) {
            Log::error('Prayer sync failed: ' . $e->getMessage());
            $this->error('Failed to sync prayer schedule: ' . $e->getMessage());
            return 1;
        }
    }
}
