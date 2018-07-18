<?php

declare(strict_types=1);

use HDNET\Autoloader\Utility\ArrayUtility;
use HDNET\Autoloader\Utility\ModelUtility;
use RGU\CalendarizeDvoconnector\Domain\Model\Config;

$base = ModelUtility::getTcaInformation(Config::class);

$custom = [
    'ctrl' => [
        'rootLevel' => -1,
        'title' => 'LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config',
    ],
    'columns' => [
        'title' => [
            'label' => 'LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.title',
        ],
        'dvo_association_id' => [
            'label' => 'LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.DVOAssociationID',
						'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'size' => 10,
                'minitems' => '1',
                'maxitems' => '1',
                'items' => [],
                'itemsProcFunc' => \RGU\CalendarizeDvoconnector\Service\PluginConfigurationService::class.'->addConfigAssociation',
                'enableMultiSelectFilterTextfield' => true,
            ],
        ],
        'filter_childs' => [
            'label' => 'LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.filterChilds',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                  ['LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.filterChilds.only_this', '0'],
                  ['LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.filterChilds.only_childs', '1'],
                  ['LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.filterChilds.this_and_childs', '2']
                ]
            ],
        ],
        'filter_private_events' => [
            'label' => 'LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.filterPrivateEvents',
            'config' => [
              'type' => 'radio',
              'items' => [
                ['LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.filterPrivateEvents.only_public', '0'],
                ['LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.filterPrivateEvents.with_private_events', '']
              ]
            ],
        ],
        'event_storage' => [
            'label' => 'LLL:EXT:calendarize_Dvoconnector/Resources/Private/Language/locallang_be.xlf:config.event_storage',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
    ],
    'palettes' => [
      'name' =>  [
        'showitem' => 'dvo_association_id, --linebreak--,
                filter_childs, filter_private_events, --linebreak--,
                event_storage',
        'canNotCollapse' => 1
      ],
    ]
];

return ArrayUtility::mergeRecursiveDistinct($base, $custom);
