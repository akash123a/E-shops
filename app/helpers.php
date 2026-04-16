<?php

use App\Models\Setting;

function setting($key)
{
    try {
        return \App\Models\Setting::where('key', $key)->value('value');
    } catch (\Exception $e) {
        return null;
    }
}