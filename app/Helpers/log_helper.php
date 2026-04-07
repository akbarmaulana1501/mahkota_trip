<?php

use App\Models\Log_activity;

function logActivity($action, $model, $model_id = null, $description = null)
{
    Log_activity::create([
        'user_id' => auth()->id(),
        'action' => $action,
        'model' => $model,
        'model_id' => $model_id,
        'description' => $description,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
}
