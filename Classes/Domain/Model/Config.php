<?php
declare(strict_types=1);

namespace RGU\CalendarizeDvoconnector\Domain\Model;
/** copyright notice **/
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Config
 *
 * @db
 * @smartExclude Language
 */
class Config extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Title.
	 *
	 * @var string
	 * @db
	 */
	protected $title;

	/**
	 * DVO Association ID
	 * @var string
	 * @db
	 */
	protected $dvoAssociationId;

	/**
	 * child modus
	 * @var string
	 * @db
	 */
	protected $filterChilds;

	/**
	 * private events
	 * @var string
	 * @db
	 */
	protected $filterPrivateEvents;

	/**
   * Event storage.
   *
   * @var string
   * @db
   */
  protected $eventStorage;

	public function __construct() {}

	/**
   * Get title.
   *
   * @return string
   */
  public function getTitle()
  {
      return $this->title;
  }
  /**
   * Set title.
   *
   * @param string $title
   */
  public function setTitle($title)
  {
      $this->title = $title;
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
	 * sets the filterChilds attribute
	 *
	 * @param string $filterChilds
	 * @return void
	 */
	public function setFilterChilds($filterChilds) {
		$this->filterChilds = $filterChilds;
	}

	/**
	 * returns the filterChilds attribute
	 *
	 * @return string
	 */
	public function getFilterChilds() {
		return $this->filterChilds;
	}

	/**
	 * sets the filterPrivateEvents attribute
	 *
	 * @param string $filterPrivateEvents
	 * @return void
	 */
	public function setFilterPrivateEvents($filterPrivateEvents) {
		$this->filterChilds = $filterPrivateEvents;
	}

	/**
	 * returns the filterPrivateEvents attribute
	 *
	 * @return string
	 */
	public function getFilterPrivateEvents() {
		return $this->filterPrivateEvents;
	}

	/**
	 * Get event storage.
	 *
	 * @return string
	 */
	public function getEventStorage()
	{
			return $this->eventStorage;
	}
	/**
	 * Set event storage.
	 *
	 * @param string $eventStorage
	 */
	public function setEventStorage($eventStorage)
	{
			$this->eventStorage = $eventStorage;
	}

}
