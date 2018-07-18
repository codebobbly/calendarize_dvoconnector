<?php

/**
 * Import default events.
 */
declare(strict_types=1);

namespace RGU\CalendarizeRgdvoconnector\Slots;

use RGU\CalendarizeRgdvoconnector\Command\AbstractCommandController;
use RGU\CalendarizeRgdvoconnector\Domain\Model\Event;
use HDNET\Calendarize\Domain\Model\Configuration;
use HDNET\Calendarize\Utility\DateTimeUtility;
/**
 * Import default events.
 */
class EventHandler {

    /**
     * Event repository.
     *
     * @var \RGU\CalendarizeRgdvoconnector\Domain\Repository\EventRepository
     */
    protected $eventRepository;

    public function __construct() {}

    /**
     * Run the import.
     *
     * @param string                                $pid
     * @param \RGU\Rgdvoconnector\Domain\Model\Event $dvoEvent
     * @param AbstractCommandController             $commandController
     * @param bool                                  $handled
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     *
     * @return array
     */
    public function importCommand($pid, $dvoEvent, $commandController, $handled) {

      $eventRepository = $this->getEventRepository();

      $event = new Event();
      $event->setPid($pid);
      $event->setDVOAssociationID($dvoEvent->getAssociation()->getID());
      $event->setDVOEventID($dvoEvent->getID());

      $event = $this->fillEventData($pid, $dvoEvent, $event);

      $eventRepository->add($event);

      $commandController->enqueueMessage('Add Event: ' . $event->getDVOAssociationID() . '|' . $event->getDVOEventID(), 'Event');

      $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
      $persistenceManager = $objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
      $persistenceManager->persistAll();

      $handled = true;

      return ['pid' => $pid, 'dvoEvent' => $dvoEvent, 'commandController' => $commandController, 'handled' => $handled ];

    }

    /**
     * Run the update.
     *
     * @param string                                           $pid
     * @param \RGU\Rgdvoconnector\Domain\Model\Event            $dvoEvent
     * @param \RGU\CalendarizeRgdvoconnector\Domain\Model\Event $event
     * @param AbstractCommandController                        $commandController
     * @param bool                                             $handled
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     *
     * @return array
     */
    public function updateCommand($pid, $dvoEvent, $event, $commandController, $handled) {

      $eventRepository = $this->getEventRepository();

      $event = $this->fillEventData($pid, $dvoEvent, $event);

      $eventRepository->update($event);

      $commandController->enqueueMessage('Update Event Meta data: ' . $event->getDVOAssociationID() . '|' . $event->getDVOEventID(), 'Event');

      $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
      $persistenceManager = $objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
      $persistenceManager->persistAll();
      $handled = true;

      return ['pid' => $pid, 'dvoEvent' => $dvoEvent, 'event' => $event, 'commandController' => $commandController, 'handled' => $handled ];

    }


    /**
     * Run the delete.
     *
     * @param string                                           $pid
     * @param \RGU\CalendarizeRgdvoconnector\Domain\Model\Event $event
     * @param AbstractCommandController                        $commandController
     * @param bool                                             $handled
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     *
     * @return array
     */
    public function deleteCommand($pid, $event, $commandController, $handled) {

      $eventRepository = $this->getEventRepository();

      $commandController->enqueueMessage('Delete Event: ' . $event->getDVOAssociationID() . '|' . $event->getDVOEventID(), 'Event');

      $eventRepository->remove($event);

      $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
      $persistenceManager = $objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
      $persistenceManager->persistAll();
      $handled = true;

      return ['pid' => $pid, 'event' => $event, 'commandController' => $commandController, 'handled' => $handled ];

    }

    /**
     * Get the configuration.
     *
     * @param string  $pid
     * @param Configuration $configuration
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     *
     * @return Configuration
     */
    protected function updateConfiguration($configuration, $startDate, $endDate = null) {

      $configuration->setType(Configuration::TYPE_TIME);
      $configuration->setFrequency(Configuration::FREQUENCY_NONE);
      $configuration->setAllDay(true);

      $startTime = clone $startDate;
      $configuration->setStartDate(DateTimeUtility::resetTime($startDate));

      if($endDate) {
        $endTime = clone $endDate;
        $configuration->setEndDate(DateTimeUtility::resetTime($endDate));
      }

      $startTime = DateTimeUtility::getDaySecondsOfDateTime($startTime);
      if ($startTime > 0) {

        $configuration->setStartTime($startTime);

        if($endTime) {
          $configuration->setEndTime(DateTimeUtility::getDaySecondsOfDateTime($endTime));
        }

        $configuration->setAllDay(false);

      }
      return $configuration;

    }

    /**
     * Get the right event object (or a new one).
     *
     * @param string                                           $pid
     * @param \RGU\Rgdvoconnector\Domain\Model\Event            $dvoEvent
     * @param \RGU\CalendarizeRgdvoconnector\Domain\Model\Event $event
     *
     * @return Event
     */
    protected function fillEventData($pid, $dvoEvent, $event) {

      $configurations = $event->getCalendarize();

      // Check, is any configuration
      if($configurations->count() == 0) {

        $configuration = new Configuration();
        $configuration->setPid($pid);

        $configurations->attach($configuration);

      }

      $firsttime = true;
      foreach ($configurations as $configuration) {

        if($firsttime) {

          $this->updateConfiguration($configuration, $dvoEvent->getStartDate(), $dvoEvent->getEndDate());
          $firsttime = false;

        } else {

          // It ist only one configuration allowed
          $configurations->detach($configuration);

        }

      }

      return $event;

    }

    /**
     * Get the event repository
     *
     * @return \RGU\CalendarizeRgdvoconnector\Domain\Repository\EventRepository
     */
    protected function getEventRepository() {

      if(!$this->eventRepository) {

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->eventRepository = $objectManager->get(\RGU\CalendarizeRgdvoconnector\Domain\Repository\EventRepository::class);

      }

      return $this->eventRepository;

    }

}
