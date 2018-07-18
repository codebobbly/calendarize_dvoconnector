<?php
namespace RGU\CalendarizeRgdvoconnector\Domain\Repository;

class ConfigRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * initialize Object
	 *
	 * @return void
	 */
	public function initializeObject() {

		$this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$this->defaultQuerySettings->setRespectStoragePage(FALSE);

	}

}
