<?php

/**
 * Utility class for date and time handling and validation
 * All comparisons and current dates use Mexico City timezone by default
 */
class DateTimeUtil {

    private const TIMEZONE = 'America/Mexico_City';

    /**
     * Gets current date/time in Mexico timezone
     *
     * @return DateTime Current date/time
     * @throws Exception If timezone cannot be set
     */
    public static function now(): DateTime {
        return new DateTime('now', new DateTimeZone(self::TIMEZONE));
    }

    /**
     * Converts a string date to a valid DateTime object
     * Supports formats: YYYY-MM-DD and DD/MM/YYYY
     *
     * @param string $dateString Date in string format
     * @return DateTime|false Returns DateTime if valid, false if not
     */
    public static function parseDate(string $dateString): DateTime|bool {
        if (empty($dateString)) {
            return false;
        }

        $tz = new DateTimeZone(self::TIMEZONE);

        // Try YYYY-MM-DD format
        $date = DateTime::createFromFormat('Y-m-d', $dateString, $tz);
        if ($date !== false && $date->format('Y-m-d') === $dateString) {
            return $date;
        }

        // Try DD/MM/YYYY format
        $date = DateTime::createFromFormat('d/m/Y', $dateString, $tz);
        if ($date !== false && $date->format('d/m/Y') === $dateString) {
            return $date;
        }

        return false;
    }

    /**
     * Converts a date-time string to a valid DateTime object
     * Supports formats: YYYY-MM-DD HH:MM:SS and DD/MM/YYYY HH:MM:SS
     *
     * @param string $dateTimeString Date-time in string format
     * @return DateTime|false
     */
    public static function parseDateTime(string $dateTimeString): DateTime|bool {
        if (empty($dateTimeString)) {
            return false;
        }

        $tz = new DateTimeZone(self::TIMEZONE);

        // Try YYYY-MM-DD HH:MM:SS format
        $dt = DateTime::createFromFormat('Y-m-d H:i:s', $dateTimeString, $tz);
        if ($dt !== false && $dt->format('Y-m-d H:i:s') === $dateTimeString) {
            return $dt;
        }

        // Try DD/MM/YYYY HH:MM:SS format
        $dt = DateTime::createFromFormat('d/m/Y H:i:s', $dateTimeString, $tz);
        if ($dt !== false && $dt->format('d/m/Y H:i:s') === $dateTimeString) {
            return $dt;
        }

        // Try DD/MM/YYYY HH:MM AM/PM format
        $dt = DateTime::createFromFormat('d/m/Y h:i A', $dateTimeString, $tz);
        if ($dt !== false && $dt->format('d/m/Y h:i A') === $dateTimeString) {
            return $dt;
        }

        return false;
    }

    /**
     * Converts date-time from DD/MM/YYYY HH:MM AM/PM format to YYYY-MM-DD HH:MM:SS format
     * Example: "04/02/2026 04:00 PM" → "2026-02-04 16:00:00"
     *
     * @param string $dateTimeString Date-time in DD/MM/YYYY HH:MM AM/PM format
     * @return string|false Formatted date-time in YYYY-MM-DD HH:MM:SS format or false if invalid
     */
    public static function convertToMySQLDateTime(string $dateTimeString): bool|string {
        if (empty($dateTimeString)) {
            return false;
        }

        // Split date and time parts
        $parts = preg_split('/\s+/', trim($dateTimeString));
        if (count($parts) < 3) {
            return false;
        }

        $datePart = $parts[0]; // DD/MM/YYYY
        $timePart = $parts[1]; // HH:MM
        $ampmPart = strtoupper($parts[2] ?? ''); // AM/PM

        // Parse and validate date part (DD/MM/YYYY)
        $dateObj = self::parseDate($datePart);
        if ($dateObj === false) {
            return false;
        }

        // Convert time to 24h format
        $time24h = date('H:i', strtotime($timePart . ' ' . $ampmPart));
        if (!$time24h) {
            return false;
        }

        // Combine date and time
        return $dateObj->format('Y-m-d') . ' ' . $time24h . ':00';
    }

    /**
     * Format a date string
     *
     * @param string|null $dateString Date in string format
     * @param string $format Output format (default 'd/m/Y')
     * @return string Formatted date or empty string if invalid date
     */
    public static function formatDate(?string $dateString, string $format = 'd/m/Y'): string {
        if (empty($dateString)) {
            return '';
        }

        $date = self::parseDate($dateString);
        if ($date === false) {
            return '';
        }

        return $date->format($format);
    }

    /**
     * Format a date-time from DB format (YYYY-MM-DD HH:MM:SS) to any desired format (e.g. 'd/m/Y H:i:s' → 14/01/2026 12:34:56, 'd.m.Y H:i' → 14.01.2026 12:34)
     *
     * @param string|null $dateTimeString Date-time in YYYY-MM-DD HH:MM:SS format
     * @param string $format Output format (default 'd/m/Y H:i:s')
     * @return string Formatted date-time or empty string if invalid date-time
     */
    public static function formatDateTime(?string $dateTimeString, string $format = 'd/m/Y H:i:s'): string {
        if (empty($dateTimeString)) {
            return '';
        }

        $dt = self::parseDateTime($dateTimeString);
        if ($dt === false) {
            return '';
        }

        return $dt->format($format);
    }

    /**
     * Validates if a date is correct (not null and valid format)
     *
     * @param string $dateString Date in YYYY-MM-DD or DD/MM/YYYY format
     * @return bool
     */
    public static function isValidDate(string $dateString): bool {
        return self::parseDate($dateString) !== false;
    }

    /**
     * Validates if a date-time is correct (not null and valid format)
     *
     * @param string $dateTimeString Date-time in YYYY-MM-DD HH:MM:SS or DD/MM/YYYY HH:MM:SS format
     * @return bool
     */
    public static function isValidDateTime(string $dateTimeString): bool {
        return self::parseDateTime($dateTimeString) !== false;
    }

    // --- Date validations ---
    /**
     * Validates if a date is in the past, compared today
     * 
     * @param string $dateString Date in YYYY-MM-DD or DD/MM/YYYY format
     * @return bool
     */
    public static function isPastDate(string $dateString): bool {
        $date = self::parseDate($dateString);
        if ($date === false) return false;
        return $date < self::now()->setTime(0, 0, 0); // Compare date only
    }

    /**
     * Validates if a date is in the future, compared today
     * 
     * @param string $dateString Date in YYYY-MM-DD or DD/MM/YYYY format
     * @return bool
     */
    public static function isFutureDate(string $dateString): bool {
        $date = self::parseDate($dateString);
        if ($date === false) return false;
        return $date > self::now()->setTime(0, 0, 0);
    }

    /**
     * Validates if a date is in the past or present, compared today
     * 
     * @param string $dateString Date in YYYY-MM-DD or DD/MM/YYYY format
     * @return bool
     */
    public static function isPastOrPresentDate(string $dateString): bool {
        $date = self::parseDate($dateString);
        if ($date === false) return false;
        return $date <= self::now()->setTime(0, 0, 0);
    }

    /**
     * Validates if a date is in the present or future, compared today
     * 
     * @param string $dateString Date in YYYY-MM-DD or DD/MM/YYYY format
     * @return bool
     */
    public static function isPresentOrFutureDate(string $dateString): bool {
        $date = self::parseDate($dateString);
        if ($date === false) return false;
        return $date >= self::now()->setTime(0, 0, 0);
    }

    /**
     * Validates if a date range is valid (start < end)
     * 
     * @param string $startDate Start date in YYYY-MM-DD or DD/MM/YYYY format
     * @param string $endDate End date in YYYY-MM-DD or DD/MM/YYYY format
     * @return bool
     */
    public static function isValidRangeDate(string $startDate, string $endDate): bool {
        $start = self::parseDate($startDate);
        $end = self::parseDate($endDate);
        if ($start === false || $end === false) return false;
        return $start < $end;
    }

    /**
     * Validates if a date range is valid and both dates are present or future
     * 
     * @param string $startDate Start date in YYYY-MM-DD or DD/MM/YYYY format
     * @param string $endDate End date in YYYY-MM-DD or DD/MM/YYYY format
     * @return bool
     */
    public static function isValidPresentOrFutureRangeDate(string $startDate, string $endDate): bool {
        $start = self::parseDate($startDate);
        $end = self::parseDate($endDate);
        if ($start === false || $end === false) return false;

        $today = self::now()->setTime(0, 0, 0);
        return $start >= $today && $end > $start;
    }

    /**
     * Compares two dates
     * 
     * @param string $startDate Start date in YYYY-MM-DD or DD/MM/YYYY format
     * @param string $endDate End date in YYYY-MM-DD or DD/MM/YYYY format
     * @return int|null Returns -1 if start < end, 1 if start > end, 0 if equal, null if invalid dates
     */
    public static function compareDates(string $startDate, string $endDate): ?int {
        $date1 = self::parseDate($startDate);
        $date2 = self::parseDate($endDate);
        if ($date1 === false || $date2 === false) return null;

        if ($date1 < $date2) return -1; // date1 is earlier
        if ($date1 > $date2) return 1; // date1 is later
        return 0; // dates are equal
    }

    // --- Date and time validations ---
    /**
     * Validates if a date-time is in the past, compared now
     * 
     * @param string $dateTimeString Date-time in YYYY-MM-DD HH:MM:SS or DD/MM/YYYY HH:MM:SS format
     * @return bool
     */
    public static function isPastTime(string $dateTimeString): bool {
        $dt = self::parseDateTime($dateTimeString);
        if ($dt === false) return false;
        return $dt < self::now();
    }

    /**
     * Validates if a date-time is in the future, compared now
     * 
     * @param string $dateTimeString Date-time in YYYY-MM-DD HH:MM:SS or DD/MM/YYYY HH:MM:SS format
     * @return bool
     */
    public static function isFutureTime(string $dateTimeString): bool {
        $dt = self::parseDateTime($dateTimeString);
        if ($dt === false) return false;
        return $dt > self::now();
    }

    /**
     * Validates if a date-time is in the past or present, compared now
     * 
     * @param string $dateTimeString Date-time in YYYY-MM-DD HH:MM:SS or DD/MM/YYYY HH:MM:SS format
     * @return bool
     */
    public static function isPastOrPresentTime(string $dateTimeString): bool {
        $dt = self::parseDateTime($dateTimeString);
        if ($dt === false) return false;
        return $dt <= self::now();
    }

    /**
     * Validates if a date-time is in the present or future, compared now
     * 
     * @param string $dateTimeString Date-time in YYYY-MM-DD HH:MM:SS or DD/MM/YYYY HH:MM:SS format
     * @return bool
     */
    public static function isPresentOrFutureTime(string $dateTimeString): bool {
        $dt = self::parseDateTime($dateTimeString);
        if ($dt === false) return false;
        return $dt >= self::now();
    }

    /**
     * Validates if a date-time range is valid (start < end)
     * 
     * @param string $startDateTime Start date-time in YYYY-MM-DD HH:MM:SS or DD/MM/YYYY HH:MM:SS format
     * @param string $endDateTime End date-time in YYYY-MM-DD HH:MM
     * @return bool
     */
    public static function isValidRangeTime(string $startDateTime, string $endDateTime): bool {
        $start = self::parseDateTime($startDateTime);
        $end = self::parseDateTime($endDateTime);
        if ($start === false || $end === false) return false;
        return $start < $end;
    }

    /**
     * Validates if a date-time range is valid and both date-times are present or future
     * 
     * @param string $startDateTime Start date-time in YYYY-MM-DD HH:MM:SS or DD/MM/YYYY HH:MM:SS format
     * @param string $endDateTime End date-time in YYYY-MM-DD HH:MM
     * @return bool
     */
    public static function isValidPresentOrFutureRangeTime(string $startDateTime, string $endDateTime): bool {
        $start = self::parseDateTime($startDateTime);
        $end = self::parseDateTime($endDateTime);
        if ($start === false || $end === false) return false;
        $now = self::now();
        return $start >= $now && $end > $start;
    }

    /**
     * Compares two date-times
     * 
     * @param string $startDateTime Start date-time in YYYY-MM-DD HH:MM:SS or DD/MM/YYYY HH:MM:SS format
     * @param string $endDateTime End date-time in YYYY-MM-DD HH:MM:SS or DD/MM/YYYY HH:MM:SS format
     * @return int|null Returns -1 if start < end, 1 if start > end, 0 if equal, null if invalid date-times
     */
    public static function compareDateTimes(string $startDateTime, string $endDateTime): ?int {
        $dt1 = self::parseDateTime($startDateTime);
        $dt2 = self::parseDateTime($endDateTime);
        if ($dt1 === false || $dt2 === false) return null;

        if ($dt1 < $dt2) return -1; // dt1 is earlier
        if ($dt1 > $dt2) return 1; // dt1 is later
        return 0; // date-times are equal
    }
}