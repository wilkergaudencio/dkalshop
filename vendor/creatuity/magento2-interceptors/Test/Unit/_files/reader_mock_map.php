<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

use Creatuity\Interception\Test\Unit\Custom\Module\Model\Item;
use Creatuity\Interception\Test\Unit\Custom\Module\Model\Item\Enhanced;
use Creatuity\Interception\Test\Unit\Custom\Module\Model\ItemPlugin\Advanced;
use Creatuity\Interception\Test\Unit\Custom\Module\Model\ItemPlugin\Simple;

return [
    [
        'global',
        [
            Item::class => [
                'plugins' => [
                    'simple_plugin' => [
                        'sortOrder' => 10,
                        'instance' => Simple::class,
                    ],
                ],
            ],
        ],
    ],
    [
        'backend',
        [
            Item::class => [
                'plugins' => [
                    'advanced_plugin' => [
                        'sortOrder' => 5,
                        'instance' => Advanced::class,
                    ],
                ],
            ],
        ]
    ],
    [
        'frontend',
        [
            Item::class => [
                'plugins' => ['simple_plugin' => ['disabled' => true]],
            ],
            Enhanced::class => [
                'plugins' => [
                    'advanced_plugin' => [
                        'sortOrder' => 5,
                        'instance' => Advanced::class,
                    ],
                ],
            ],
            'SomeType' => [
                'plugins' => [
                    'simple_plugin' => [
                        'instance' => 'NonExistingPluginClass',
                    ],
                ],
            ],
            'typeWithoutInstance' => [
                'plugins' => [
                    'simple_plugin' => [],
                ],
            ]
        ]
    ],
    [
        'emptyscope',
        [

        ]
    ]
];
