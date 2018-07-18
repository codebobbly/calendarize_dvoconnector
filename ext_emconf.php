<?php
/**
 * $EM_CONF
 *
 * @category   Extension
 * @author     rguttroff.de
 */
$EM_CONF[$_EXTKEY] = [
    'title'            => 'Calendarize fir DVO Events',
    'description'      => 'Integrate Dvoconnector with Calendarize',
    'category'         => 'fe',
    'version'          => '1.0.1',
    'state'            => 'stable',
    'clearcacheonload' => 1,
    'author'           => 'codebobbly',
    'author_email'     => 'codebobbly@gmail.com',
    'constraints'      => [
        'depends' => [
            'typo3'       => '7.6.0-*',
            'calendarize' => '3.1.0-0.0.0',
            'dvoconnector' => '1.0.0-*',
        ],
    ],
];
