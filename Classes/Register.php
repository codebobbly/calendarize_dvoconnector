<?php
/**
 * Register options
 *
 * @package RGU\CalendarizeDvoconnector
 * @author  rguttroff.de
 */

namespace RGU\CalendarizeDvoconnector;

/**
 * Register options
 *
 * @author rguttroff.de
 */

class Register
{

    /**
     * Get the autoloader configuration
     *
     * @return array
     */
    public static function getAutoloaderConfiguration()
    {
        return [
            'StaticTyposcript',
            'SmartObjects',
            'Slots',
            'CommandController'
        ];
    }

    /**
     * Get the configuration
     *
     * @return array
     */
    public static function getConfiguration()
    {
        return [
            'uniqueRegisterKey' => 'Dvoconnector',
            'title'             => 'Dvoconnector Event',
            'modelName'         => \RGU\CalendarizeDvoconnector\Domain\Model\Event::class,
            'partialIdentifier' => 'Dvoconnector',
            'tableName'         => 'tx_calendarizeDvoconnector_domain_model_event',
            'required'          => false,
        ];
    }
}
