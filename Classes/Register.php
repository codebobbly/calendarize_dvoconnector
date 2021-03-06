<?php
/**
 * Register options
 *
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
            'uniqueRegisterKey' => 'dvoconnector',
            'title'             => 'Dvoconnector Event',
            'modelName'         => \RGU\CalendarizeDvoconnector\Domain\Model\Event::class,
            'partialIdentifier' => 'dvoconnector',
            'tableName'         => 'tx_calendarizedvoconnector_domain_model_event',
            'required'          => false,
        ];
    }
}
