<?php

declare(strict_types=1);

use HDNET\Autoloader\Utility\ArrayUtility;
use HDNET\Autoloader\Utility\ModelUtility;
use RGU\CalendarizeDvoconnector\Domain\Model\Event;

$base = ModelUtility::getTcaInformation(Event::class);

$custom = [
    'ctrl' => [
        'hideTable' => true,
        'title' => 'LLL:EXT:calendarize_dvoconnector/Resources/Private/Language/locallang_be.xlf:events',
    ],
];

return ArrayUtility::mergeRecursiveDistinct($base, $custom);
