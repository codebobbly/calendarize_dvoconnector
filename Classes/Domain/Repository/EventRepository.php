<?php
namespace RGU\CalendarizeDvoconnector\Domain\Repository;

use RGU\CalendarizeDvoconnector\Domain\Model\Event;

class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Override page IDs.
     *
     * @param array $overridePageIds
     */
    public function setOverridePageIds($overridePageIds)
    {
        if (!$this->defaultQuerySettings) {
            $querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
            $this->setDefaultQuerySettings($querySettings);
        }

        $this->defaultQuerySettings->setStoragePageIds($overridePageIds);
    }
    /**
     * search for event with dvo event ID
     *
     * @param string $eid
     * @param string $configUid
     * @return Event
     */
    public function findByDVOEventID($eid)
    {
        $query = $this->createQuery();
        $result = $query->matching($query->equals('dvo_event_id', $eid))->setLimit(1)->execute();

        if ($result instanceof \TYPO3\CMS\Extbase\Persistence\QueryResultInterface) {
            $finalResult = $result->getFirst();
        } elseif (is_array($result)) {
            $finalResult = isset($result[0]) ? $result[0] : null;
        }

        return $finalResult;
    }
}
