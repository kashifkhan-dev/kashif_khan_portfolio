<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public function getAllSettings(): array
    {
        return Setting::pluck('value', 'key')->toArray();
    }

    public function updateSettings(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::setByKey($key, is_array($value) ? json_encode($value) : (string)$value);
        }
    }
}
