<?php

namespace App\Utilities;

use Carbon\Carbon;

class ClientUtilities
{
    const NO_RECORDS_YET = 'No records yet';
    const WARNING = 'Warning';
    const CRITICAL = 'Critical';
    const HEALTHY = 'Healthy';

    /**
     * @return string
     */
    public static function generateToken()
    {
        return str_random(60);
    }

    /**
     * @param $status
     * @return int
     */
    public static function convertStatus($status)
    {
        $boolStatus = 0;

        if ($status && $status == 'on') {
            $boolStatus = 1;
        }

        return $boolStatus;
    }

    /**
     * @param $health
     * @return string
     */
    public static function getStatusLabel($health)
    {
        $label = 'info';
        if ($health === self::HEALTHY) {
            $label = 'success';
        } elseif ($health === self::WARNING) {
            $label = 'warning';
        } elseif ($health === self::CRITICAL) {
            $label = 'danger';
        }

        return $label;
    }

    /**
     * @param $health
     * @return string
     */
    public static function getBackground($health)
    {
        $bg = 'aqua';
        if ($health === self::HEALTHY) {
            $bg = 'green';
        } elseif ($health === self::WARNING) {
            $bg = 'yellow';
        } elseif ($health === self::CRITICAL) {
            $bg = 'red';
        }

        return $bg;
    }

    /**
     * @param $health
     * @return string
     */
    public static function getBackgroundIcon($health)
    {
        $bgIcon = 'flag';
        if ($health === self::WARNING || $health === self::CRITICAL) {
            $bgIcon = 'ban';
        } elseif ($health === self::HEALTHY) {
            $bgIcon = 'heart';
        }

        return $bgIcon;
    }

    /**
     * @param $heartbeat
     * @param $warning
     * @param $critical
     * @return string
     */
    public static function getHealth($heartbeat, $warning, $critical)
    {
        $now = Carbon::now();
        $status = self::getBaseHealth();
        if ($heartbeat) {
            $diff = $now->diffInSeconds(Carbon::parse($heartbeat));
            $status = self::getHealthStatus($diff, $warning, $critical);
        }

        return $status;
    }

    /**
     * @param $diff
     * @param $warning
     * @param $critical
     * @return string
     */
    public static function getHealthStatus($diff, $warning, $critical)
    {
        $status = self::getBaseHealth();

        if ($diff > $critical) {
            $status = self::CRITICAL;
        } elseif ($diff > $warning) {
            $status = self::WARNING;
        } elseif ($diff < $warning) {
            $status = self::HEALTHY;
        }

        return $status;
    }

    /**
     * @return string
     */
    protected static function getBaseHealth()
    {
        return self::NO_RECORDS_YET;
    }
}
