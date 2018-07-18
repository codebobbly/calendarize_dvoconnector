<?php
/**
 * $EM_CONF
 *
 * @category   Extension
 * @package    CalendarizeRgdvoconnector
 * @author     rguttroff.de
 */


$EM_CONF[$_EXTKEY] = [
    'title'            => 'Calendarize fir DVO Events',
    'description'      => 'Integrate Rgdvoconnector with Calendarize',
    'category'         => 'fe',
    'version'          => '1.0.1',
    'state'            => 'stable',
    'clearcacheonload' => 1,
    'author'           => 'rguttroff.de',
    'author_email'     => 'typo3-calendarizeRgdvoconnector@as.rguttroff.de',
    'constraints'      => [
        'depends' => [
            'typo3'       => '7.6.0-*',
            'calendarize' => '3.1.0-0.0.0',
            'rgdvoconnector' => '1.0.0-*',
        ],
    ],
];
