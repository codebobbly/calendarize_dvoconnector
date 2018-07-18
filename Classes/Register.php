<?php
/**
 * Register options
 *
 * @package RG\CalendarizeRgdvoconnector
 * @author  rguttroff.de
 */

namespace RG\CalendarizeRgdvoconnector;

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
            'uniqueRegisterKey' => 'Rgdvoconnector',
            'title'             => 'Rgdvoconnector Event',
            'modelName'         => \RG\CalendarizeRgdvoconnector\Domain\Model\Event::class,
            'partialIdentifier' => 'Rgdvoconnector',
            'tableName'         => 'tx_calendarizergdvoconnector_domain_model_event',
            'required'          => false,
        ];
    }
}
