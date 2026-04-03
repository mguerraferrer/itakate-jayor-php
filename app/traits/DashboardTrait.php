<?php

trait DashboardTrait {

    /**
     * Format dates in list
     *
     * @param array $list List array
     * @return array Formatted list array
     */
    protected static function formatDates(array $list): array {
        foreach ($list as &$item) {
            $item = self::formatDate($item);
        }
        unset($item);
        return $list;
    }
    
    /**
     * Format date for a single item
     *
     * @param array $item Item data
     * @return array Formatted item data
     */
    protected static function formatDate(array $item): array {
        if (!empty($item['date'])) {
            $item['date'] = DateTimeUtil::formatDate($item['date']);
        }
        return $item;
    }

}