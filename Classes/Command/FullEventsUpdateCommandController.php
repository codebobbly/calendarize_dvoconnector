<?php
/**
 * Import
 *
 * @author rguttroff.de
 */

namespace RG\CalendarizeRgdvoconnector\Command;

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use HDNET\Calendarize\Service\IndexerService;
use RG\CalendarizeRgdvoconnector\Domain\Model\Config;
use RG\Rgdvoconnector\Domain\Filter\EventsFilter;
use RG\Rgdvoconnector\Service\GenericApiService;

/**
 * Import
 *
 * @author rguttroff.de
 */
class FullEventsUpdateCommandController extends AbstractCommandController {

  /**
   * configRepository
   * @var RG\CalendarizeRgdvoconnector\Domain\Repository\ConfigRepository
   * @inject
   */
  protected $configRepository;

  /**
   * eventRepository
   * @var RG\CalendarizeRgdvoconnector\Domain\Repository\EventRepository
   * @inject
   */
  protected $eventRepository;

  /**
   * associationRepository
   * @var RG\Rgdvoconnector\Domain\Repository\AssociationRepository
   * @inject
   */
  protected $dvoAssociationRepository;

  /**
   * eventRepository
   * @var RG\Rgdvoconnector\Domain\Repository\EventRepository
   * @inject
   */
  protected $dvoEventRepository;

  /**
   * The index repository.
   * @var \HDNET\Calendarize\Domain\Repository\IndexRepository
   * @inject
   */
  protected $indexRepository;

  /**
   * Import command
   */
  public function importCommand() {

    GenericApiService::disableCache();

    $pluginConfiguration = \RG\CalendarizeRgdvoconnector\Register::getConfiguration();

    $this->indexRepository->setIndexTypes([$pluginConfiguration['uniqueRegisterKey']]);

    $eventsInSystem = [];
    $eventsInCloud = [];

    foreach($this->configRepository->findAll() as $config) {

      $association = $this->dvoAssociationRepository->findByID($config->getDVOAssociationID());
      if($association) {

        $eventFilter = $this->getEventsFilter($config);
        $pid = $config->getEventStorage();

        $eventsInSystem[$pid] = $eventsInSystem[$pid] || [];

        $this->indexRepository->setOverridePageIds([$pid]);

        $indices = $this->indexRepository->findBySearch($eventFilter->getStartDate(), $eventFilter->getEndDate());
        foreach($indices as $entry) {

          $event = $entry->getOriginalObject();
          if($event) {
            $eventsInSystem[$pid][$event->getDVOEventID()] = $event;
          }

        }

        $events = $this->dvoEventRepository->findEventsByAssociation($association, $eventFilter);
        $eventList = $events->getEvents();
        foreach($eventList as $event) {

          $eventsInCloud[$event->getID()] = $event;

        }

      } else {
        $this->enqueueMessage('Aassociation '. $config->getDVOAssociationID() .' not found!', 'Error', FlashMessage::ERROR);
      }

    }

    GenericApiService::enableCache();

    // Search for Events with an old start/enddate
    // All deleted Events can only be found by fullupdate
    foreach($eventsInCloud as $eid => $event) {
      foreach($eventsInSystem as $pid => $events) {

        $this->eventRepository->setOverridePageIds([$pid]);

        if(!array_key_exists($eid, $events)) {
          $eventsInSystem[$pid][$eid] = $this->eventRepository->findByDVOEventID($eid);
        }

      }
    }

    $this->enqueueMessage('Found ' . count($eventsInSystem) . ' events in the given calendar (System)', 'Items', FlashMessage::INFO);
    $this->enqueueMessage('Found ' . count($eventsInCloud) . ' events in the given calendar (Cloud)', 'Items', FlashMessage::INFO);

    /** @var Dispatcher $signalSlotDispatcher */
    $signalSlotDispatcher = GeneralUtility::makeInstance(Dispatcher::class);

    $this->enqueueMessage('Send the ' . __CLASS__ . '::importCommand signal for each event.', 'Signal', FlashMessage::INFO);
    $this->enqueueMessage('Send the ' . __CLASS__ . '::deleteCommand signal for each event.', 'Signal', FlashMessage::INFO);
    $this->enqueueMessage('Send the ' . __CLASS__ . '::updateCommand signal for each event.', 'Signal', FlashMessage::INFO);

    $eventIDsForDelete = [];

    foreach($eventsInSystem as $pid => $events) {
      $eventIDsForDelete[$pid] = array_keys($events);
    }

    foreach($eventsInCloud as $eid => $dvoEvent) {

      foreach($eventsInSystem as $pid => $events) {

        $event = $events[$eid];
        if($event) {

          $arguments = [
            'pid'               => $pid,
            'dvoEvent'          => $dvoEvent,
            'event'             => $event,
            'commandController' => $this,
            'handled'           => false
          ];

          $signalSlotDispatcher->dispatch(__CLASS__, 'updateCommand', $arguments);

        } else {

          $arguments = [
            'pid'               => $pid,
            'dvoEvent'          => $dvoEvent,
            'commandController' => $this,
            'handled'           => false
          ];

          $signalSlotDispatcher->dispatch(__CLASS__, 'importCommand', $arguments);

        }

        $eventIDsForDelete[$pid] = array_diff($eventIDsForDelete[$pid], [$eid]);

      }

    }

    foreach($eventIDsForDelete as $pid => $events) {
      foreach($events as $eid) {

        $event = $eventsInSystem[$pid][$eid];
        if($event) {

          $arguments = [
            'pid'               => $pid,
            'event'             => $event,
            'commandController' => $this,
            'handled'           => false
          ];

          $signalSlotDispatcher->dispatch(__CLASS__, 'deleteCommand', $arguments);

        }

      }
    }

    $indexer = $this->objectManager->get(IndexerService::class);
    $indexer->reindexAll();

  }

  /**
   * Get Filter for Events
   * @param Config $config
   *
   * @return EventsFilter
   */
   protected function getEventsFilter($config) {

     $filter = new EventsFilter();
     $filter->setPrivateEvents($config->getFilterPrivateEvents());
     $filter->setChilds($config->getFilterChilds());
     $filter->setInsideAssociationID($config->getDVOAssociationID());

     return $filter;

   }

}
