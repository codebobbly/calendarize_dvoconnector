<?php

declare(strict_types=1);

use HDNET\Autoloader\Utility\ArrayUtility;
use HDNET\Autoloader\Utility\ModelUtility;
use RG\CalendarizeRgdvoconnector\Domain\Model\Event;

$base = ModelUtility::getTcaInformation(Event::class);

$custom = [
    'ctrl' => [
        'hideTable' => true,
    ],
];

return ArrayUtility::mergeRecursiveDistinct($base, $custom);
