<?php
/**
 * Import
 *
 * @author  rguttroff.de
 */

namespace RGU\CalendarizeRgdvoconnector\Command;

use RGU\CalendarizeRgdvoconnector\Domain\Model\Config;
use RGU\Rgdvoconnector\Domain\Filter\EventsFilter;

/**
 * Import
 *
 * @author rguttroff.de
 */
class CurrentEventsUpdateCommandController extends FullEventsUpdateCommandController {

  /**
   * Get Filter for Events
   * @param Config $config
   *
   * @return EventsFilter
   */
  protected function getEventsFilter($config) {

    $filter = parent::getEventsFilter($config);

    $startDate = new \DateTime("now");
    $filter->setStartDate($startDate);

    return $filter;

  }

}
