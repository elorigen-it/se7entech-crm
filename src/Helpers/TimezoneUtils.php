<?php

namespace Se7entech\Contractnew\Helpers;

class TimezoneUtils {

    public static function fromUserTimeZoneDateStringToTimestamp($userDateString, $userTimezone = null) 
    {
        $userTimezone = $userTimezone ?? date_default_timezone_get() ?? 'UTC';
        $date = new \DateTime($userDateString, new \DateTimeZone($userTimezone));
        $date->setTimezone(new \DateTimeZone('UTC'));       
        return $date->getTimestamp();
    }

    public static function fromTimestampToUserTimezoneDateString(int $timestamp, ?string $userTimezone = null, $formatString = 'Y-m-d H:i') 
    {
        $userTimezone = date_default_timezone_get() ?? 'UTC';
        
        if ($userTimezone === 'UTC') {
            return gmdate($formatString, $timestamp);
        }
        return date($formatString, $timestamp);
        
    }

    public static function formatUTCDateStringForUserTimezone($utcDateString, $userTimezone = null, $formatString = 'Y-m-d H:i:s') 
    {
        $userTimezone = date_default_timezone_get() ?? 'UTC';
        
        $utcDate = new \DateTime($utcDateString, new \DateTimeZone('UTC'));
        $utcDate->setTimezone(new \DateTimeZone($userTimezone));
        
        return $utcDate->format($formatString);
    }

    public static function formatTimestampForUserTimezone(int $timestamp, ?string $userTimezone = null, $formatString = 'Y-m-d H:i'): string
    {
        $userTimezone = date_default_timezone_get() ?? 'UTC';
        
        if ($userTimezone === 'UTC') {
            return gmdate($formatString, $timestamp);
        }
        
        try {
            // Obtener el offset de la zona horaria para este timestamp
            $tz = new \DateTimeZone($userTimezone);
            $transition = $tz->getTransitions($timestamp, $timestamp);
            $offset = $transition[0]['offset'] ?? 0;
            // Aplicar el offset
            return date($formatString, $timestamp + $offset);
            
        } catch (Exception $e) {
            return gmdate($formatString, $timestamp);
        }
    }

    public static function userDateStringToTimestamp(string $utcDateString): int
    {
        $userTimezone = date_default_timezone_get() ?? 'UTC';
        $utcDate = new \DateTime($utcDateString, new \DateTimeZone($userTimezone));
        return $utcDate->getTimestamp();
    }
}