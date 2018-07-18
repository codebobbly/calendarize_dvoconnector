<?php
/**
 * General ext_localconf file and also an example for your own extension
 *
 * @category   Extension
 * @package    CalendarizeRgdvoconnector
 * @author     rguttroff.de
 */


if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\HDNET\Autoloader\Loader::extLocalconf(
    'RG',
    'calendarize_rgdvoconnector',
    \RG\CalendarizeRgdvoconnector\Register::getAutoloaderConfiguration()
);
\HDNET\Calendarize\Register::extLocalconf(\RG\CalendarizeRgdvoconnector\Register::getConfiguration());

$eventHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\RG\CalendarizeRgdvoconnector\Slots\EventHandler::class);

$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \RG\CalendarizeRgdvoconnector\Command\FullEventsUpdateCommandController::class,
    'importCommand',
    $eventHandler,
    'importCommand'
);
$signalSlotDispatcher->connect(
    \RG\CalendarizeRgdvoconnector\Command\FullEventsUpdateCommandController::class,
    'deleteCommand',
    $eventHandler,
    'deleteCommand'
);
$signalSlotDispatcher->connect(
    \RG\CalendarizeRgdvoconnector\Command\FullEventsUpdateCommandController::class,
    'updateCommand',
    $eventHandler,
    'updateCommand'
);

$signalSlotDispatcher->connect(
    \RG\CalendarizeRgdvoconnector\Command\CurrentEventsUpdateCommandController::class,
    'importCommand',
    $eventHandler,
    'importCommand'
);
$signalSlotDispatcher->connect(
    \RG\CalendarizeRgdvoconnector\Command\CurrentEventsUpdateCommandController::class,
    'deleteCommand',
    $eventHandler,
    'deleteCommand'
);
$signalSlotDispatcher->connect(
    \RG\CalendarizeRgdvoconnector\Command\CurrentEventsUpdateCommandController::class,
    'updateCommand',
    $eventHandler,
    'updateCommand'
);
