<?php
/**
 * General ext_tables file and also an example for your own extension
 *
 * @category   Extension
 * @author     rguttroff.de
 */
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\HDNET\Autoloader\Loader::extTables('RG', 'calendarize_dvoconnector', \RGU\CalendarizeDvoconnector\Register::getAutoloaderConfiguration());
\HDNET\Calendarize\Register::extTables(\RGU\CalendarizeDvoconnector\Register::getConfiguration());

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_calendarize_dvoconnector_domain_model_config');
