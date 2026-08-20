<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Models\ScanHistory;
use App\Models\User;

trait ApiHelpersTrait
{
    protected function consumerScanCount($codeId)
    {
        return ScanHistory::where('scan_histories.code_id', $codeId)
            ->join('users', 'users.id', '=', 'scan_histories.scanned_by')
            ->where('users.type', '0')
            ->count();
    }

    protected function maskPhone($user)
    {
        if (!$user) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', (string) $user->phone);

        if (strlen($phone) < 4) {
            return null;
        }

        return substr($phone, 0, 3) . str_repeat('*', max(strlen($phone) - 3, 0));
    }

    protected function maskPhoneById($userId)
    {
        return $this->maskPhone($userId ? User::find($userId) : null);
    }
}
