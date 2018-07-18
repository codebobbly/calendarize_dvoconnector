<?php
/**
 * Import
 *
 * @author  rguttroff.de
 */

namespace RG\CalendarizeRgdvoconnector\Command;

use TYPO3\CMS\Core\Messaging\FlashMessage;

/**
 * Import
 *
 * @author rguttroff.de
 */
class CleanupEventsCommandController extends AbstractCommandController {

  /**
   * Event repository.
   *
   * @var \RG\CalendarizeRgdvoconnector\Domain\Repository\EventRepository
   */
  protected $eventRepository;

  /**
   * Import command
   */
  public function fullCleanupCommand() {

    $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
    $this->eventRepository = $objectManager->get(\RG\CalendarizeRgdvoconnector\Domain\Repository\EventRepository::class);

    $events = $this->eventRepository->findAll();
    foreach($events as $event) {

      $this->enqueueMessage('Remove Event' . $event->getDVOEventID(), 'Items', FlashMessage::INFO);
      $this->eventRepository->remove($event);

    }

  }

}
