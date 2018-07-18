<?php
/**
 * General ext_tables file and also an example for your own extension
 *
 * @category   Extension
 * @package    CalendarizeRgdvoconnector
 * @author     rguttroff.de
 */

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\HDNET\Autoloader\Loader::extTables('RG', 'calendarize_rgdvoconnector', \RG\CalendarizeRgdvoconnector\Register::getAutoloaderConfiguration());
\HDNET\Calendarize\Register::extTables(\RG\CalendarizeRgdvoconnector\Register::getConfiguration());

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_calendarize_rgdvoconnector_domain_model_config');
