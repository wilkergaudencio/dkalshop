<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Creatuity\Interception\Test\Unit\CompiledPluginList;

use Creatuity\Interception\Generator\StaticScope;
use Magento\Framework\App\ObjectManager;
use Creatuity\Interception\Generator\CompiledPluginList;
use Creatuity\Interception\Test\Unit\Custom\Module\Model\Item;
use Creatuity\Interception\Test\Unit\Custom\Module\Model\Item\Enhanced;
use Creatuity\Interception\Test\Unit\Custom\Module\Model\ItemPlugin\Advanced;
use Creatuity\Interception\Test\Unit\Custom\Module\Model\ItemPlugin\Simple;
use Psr\Log\NullLogger;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CompiledPluginListTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var CompiledPluginList[]
     */
    private $objects;

    protected function setUp()
    {
        $this->objects = $this->createScopeReaders();
    }

    public function createScopeReaders()
    {
        $readerMap = include __DIR__ . '/../_files/reader_mock_map.php';
        $readerMock = $this->createMock(\Magento\Framework\ObjectManager\Config\Reader\Dom::class);
        $readerMock->expects($this->any())->method('read')->will($this->returnValueMap($readerMap));

        $omMock = $this->createMock(ObjectManager::class);
        $omMock->method('get')->with(\Psr\Log\LoggerInterface::class)->willReturn(new NullLogger());

        $omConfigMock =  $this->getMockForAbstractClass(
            \Magento\Framework\Interception\ObjectManager\ConfigInterface::class
        );

        $omConfigMock->expects($this->any())->method('getOriginalInstanceType')->will($this->returnArgument(0));
        $ret = [];
        $objectManagerHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        foreach ($readerMap as $readerLine) {
            $ret[$readerLine[0]] = $objectManagerHelper->getObject(
                CompiledPluginList::class,
                [
                    'objectManager' => $omMock,
                    'scope' => new StaticScope($readerLine[0]),
                    'reader' => $readerMock,
                    'omConfig' => $omConfigMock,
                    'cachePath' => false
                ]
            );
        }
        return $ret;
    }

    public function testGetPlugin()
    {

        $this->objects['backend']->getNext(Item::class, 'getName');
        $this->assertEquals(
            Simple::class,
            $this->objects['backend']->getPluginType(
                Item::class,
                'simple_plugin'
            )
        );
        $this->assertEquals(
            Advanced::class,
            $this->objects['backend']->getPluginType(
                Item::class,
                'advanced_plugin'
            )
        );
    }

    /**
     * @param $expectedResult
     * @param $type
     * @param $method
     * @param $scopeCode
     * @param string $code
     * @dataProvider getPluginsDataProvider
     */
    public function testGetPlugins($expectedResult, $type, $method, $scopeCode, $code = '__self')
    {
        $this->assertEquals($expectedResult, $this->objects[$scopeCode]->getNext($type, $method, $code));
    }

    /**
     * @return array
     */
    public function getPluginsDataProvider()
    {
        return [
            [
                [4 => ['simple_plugin']], Item::class,
                'getName',
                'global',
            ],
            [
                // advanced plugin has lower sort order
                [2 => 'advanced_plugin', 4 => ['advanced_plugin'], 1 => ['advanced_plugin']],
                Item::class,
                'getName',
                'backend'
            ],
            [
                // advanced plugin has lower sort order
                [4 => ['simple_plugin']],
                Item::class,
                'getName',
                'backend',
                'advanced_plugin'
            ],
            // simple plugin is disabled in configuration for
            // \Creatuity\Interception\Test\Unit\Custom\Module\Model\Item in frontend
            [null, Item::class, 'getName', 'frontend'],
            // test plugin inheritance
            [
                [4 => ['simple_plugin']],
                Enhanced::class,
                'getName',
                'global'
            ],
            [
                // simple plugin is disabled in configuration for parent
                [2 => 'advanced_plugin', 4 => ['advanced_plugin'], 1 => ['advanced_plugin']],
                Enhanced::class,
                'getName',
                'frontend'
            ]
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @covers \Magento\Framework\Interception\PluginList\PluginList::getNext
     * @covers \Magento\Framework\Interception\PluginList\PluginList::_inheritPlugins
     */
    public function testInheritPluginsWithNonExistingClass()
    {
        $this->objects['frontend']->getNext('SomeType', 'someMethod');
    }

    /**
     * @covers \Magento\Framework\Interception\PluginList\PluginList::getNext
     * @covers \Magento\Framework\Interception\PluginList\PluginList::_inheritPlugins
     */
    public function testInheritPluginsWithNotExistingPlugin()
    {
        $this->assertNull($this->objects['frontend']->getNext('typeWithoutInstance', 'someMethod'));
    }
}
