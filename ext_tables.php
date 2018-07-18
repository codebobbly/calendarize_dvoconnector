<?php
/**
 * General ext_tables file and also an example for your own extension
 *
 * @category   Extension
 * @package    CalendarizeDvoconnector
 * @author     rguttroff.de
 */

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\HDNET\Autoloader\Loader::extTables('RG', 'calendarize_Dvoconnector', \RGU\CalendarizeDvoconnector\Register::getAutoloaderConfiguration());
\HDNET\Calendarize\Register::extTables(\RGU\CalendarizeDvoconnector\Register::getConfiguration());

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_calendarize_Dvoconnector_domain_model_config');
