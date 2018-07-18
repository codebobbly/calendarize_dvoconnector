<?php
/**
 * General ext_localconf file and also an example for your own extension
 *
 * @category   Extension
 * @author     rguttroff.de
 */
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\HDNET\Autoloader\Loader::extLocalconf(
    'RG',
    'calendarize_dvoconnector',
    \RGU\CalendarizeDvoconnector\Register::getAutoloaderConfiguration()
);
\HDNET\Calendarize\Register::extLocalconf(\RGU\CalendarizeDvoconnector\Register::getConfiguration());

$eventHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\RGU\CalendarizeDvoconnector\Slots\EventHandler::class);

$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \RGU\CalendarizeDvoconnector\Command\FullEventsUpdateCommandController::class,
    'importCommand',
    $eventHandler,
    'importCommand'
);
$signalSlotDispatcher->connect(
    \RGU\CalendarizeDvoconnector\Command\FullEventsUpdateCommandController::class,
    'deleteCommand',
    $eventHandler,
    'deleteCommand'
);
$signalSlotDispatcher->connect(
    \RGU\CalendarizeDvoconnector\Command\FullEventsUpdateCommandController::class,
    'updateCommand',
    $eventHandler,
    'updateCommand'
);

$signalSlotDispatcher->connect(
    \RGU\CalendarizeDvoconnector\Command\CurrentEventsUpdateCommandController::class,
    'importCommand',
    $eventHandler,
    'importCommand'
);
$signalSlotDispatcher->connect(
    \RGU\CalendarizeDvoconnector\Command\CurrentEventsUpdateCommandController::class,
    'deleteCommand',
    $eventHandler,
    'deleteCommand'
);
$signalSlotDispatcher->connect(
    \RGU\CalendarizeDvoconnector\Command\CurrentEventsUpdateCommandController::class,
    'updateCommand',
    $eventHandler,
    'updateCommand'
);
