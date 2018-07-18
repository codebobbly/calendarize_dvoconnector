<?php
declare(strict_types=1);

namespace RGU\CalendarizeRgdvoconnector\Domain\Model;
/** copyright notice **/
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use HDNET\Calendarize\Features\FeedInterface;
use HDNET\Calendarize\Features\SpeakingUrlInterface;

/**
 * Event
 *
 * @db
 * @smartExclude Language, calendarize
 */
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity implements FeedInterface, SpeakingUrlInterface {

	/**
	 * DVO Association ID
	 * @var string
	 * @db
	 */
	protected $dvoAssociationId;

	/**
	 * DVO Event ID
	 * @var string
	 * @db
	 */
	protected $dvoEventId;

	/**
	 * Relation field. It is just used by the importer of the default events.
	 * You do not need this field, if you don't use the default Event.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HDNET\Calendarize\Domain\Model\Configuration>
	 */
	protected $calendarize;

	/**
	 * AssociationRepository
	 * @var \RGU\Rgdvoconnector\Domain\Repository\AssociationRepository
	 */
	protected $associationRepository;

	/**
	 * EventRepository
	 * @var \RGU\Rgdvoconnector\Domain\Repository\EventRepository
	 */
	protected $eventRepository;

	/**
	 * Configs.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RGU\CalendarizeRgdvoconnector\Domain\Model\Config>
	 * @db text
	 * @lazy
	 */
	protected $configs;

	public function __construct() {
		$this->calendarize = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * sets the dvoEventId attribute
	 *
	 * @param string $dvoEventId
	 * @return void
	 */
	public function setDVOEventID($dvoEventId) {
		$this->dvoEventId = $dvoEventId;
	}

	/**
	 * returns the dvoEventId attribute
	 *
	 * @return string
	 */
	public function getDVOEventID() {
		return $this->dvoEventId;
	}

	/**
	 * sets the dvoAssociationId attribute
	 *
	 * @param string $dvoAssociationId
	 * @return void
	 */
	public function setDVOAssociationID($dvoAssociationId) {
		$this->dvoAssociationId = $dvoAssociationId;
	}

	/**
	 * returns the dvoAssociationId attribute
	 *
	 * @return string
	 */
	public function getDVOAssociationID() {
		return $this->dvoAssociationId;
	}

	/**
	 * Get calendarize.
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HDNET\Calendarize\Domain\Model\Configuration>
	 */
	public function getCalendarize() {
		return $this->calendarize;
	}
	/**
	 * Set calendarize.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HDNET\Calendarize\Domain\Model\Configuration> $calendarize
	 */
	public function setCalendarize($calendarize) {
		$this->calendarize = $calendarize;
	}
	/**
	 * Add one calendarize configuration.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HDNET\Calendarize\Domain\Model\Configuration> $calendarize
	 */
	public function addCalendarize($calendarize) {
		$this->calendarize->attach($calendarize);
	}

	/**
   * Get the feed title.
   *
   * @return string
   */
  public function getFeedTitle(): string {
    return (string) $this->getEvent()->getTitle();
  }

  /**
   * Get the feed abstract.
   *
   * @return string
   */
  public function getFeedAbstract(): string {
    return (string) $this->getFeedContent();
  }

  /**
   * Get the feed content.
   *
   * @return string
   */
  public function getFeedContent(): string {
    return (string) $this->getEvent()->getDescription();
  }

  /**
   * Get the feed location.
   *
   * @return string
   */
  public function getFeedLocation(): string {
    return (string) $this->getEvent()->getEventlocation();
  }

  /**
   * Get the base for the realurl alias.
   *
   * @return string
   */
  public function getRealUrlAliasBase(): string {
    return (string) $this->getEvent()->getTitle();
  }

	/**
   * return the orginal association
   *
   * @return RGU\Rgdvoconnector\Domain\Model\Association
   */
  public function getAssociation() {

		if(!$this->associationRepository) {
			$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
			$this->associationRepository = $objectManager->get(\RGU\Rgdvoconnector\Domain\Repository\AssociationRepository::class);
		}

    return $this->associationRepository->findByID($this->getDVOAssociationID());

  }

	/**
   * return the orginal event
   *
   * @return RGU\Rgdvoconnector\Domain\Model\Event
   */
  public function getEvent() {

		$association = $this->getAssociation();
		if($association) {

			if(!$this->eventRepository) {
				$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
				$this->eventRepository = $objectManager->get(\RGU\Rgdvoconnector\Domain\Repository\EventRepository::class);
			}

	    return $this->eventRepository->findByAssociationAndID($association, $this->getDVOEventID());

		} else {
			return null;
		}

  }

	/**
	 * Get configs.
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getConfigs() {
			return $this->configs;
	}

	/**
	 * Set configs.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $configs
	 */
	public function setConfigs($configs) {
			$this->configs = $configs;
	}

}
