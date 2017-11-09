<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Unit;

use Omines\DataTablesBundle\DataTablesBundle;
use Omines\DataTablesBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * DependencyInjectionTest.
 *
 * @author Niels Keurentjes <niels.keurentjes@omines.com>
 */
class DependencyInjectionTest extends TestCase
{
    public function testConfiguration()
    {
        $config = new Configuration();
        $tree = $config->getConfigTreeBuilder()->buildTree();

        $this->assertInstanceOf(ArrayNode::class, $tree);
    }

    public function testExtension()
    {
        $bundle = new DataTablesBundle();
        $extension = $bundle->getContainerExtension();
        $this->assertSame('datatables', $extension->getAlias());

        $container = new ContainerBuilder();
        $extension->load([], $container);

        // Default should have no options
        $this->assertEmpty($options = $container->getParameter('datatables.options'));

        // Default settings are meaningful
        $this->assertNotEmpty($settings = $container->getParameter('datatables.settings'));
        $this->assertSame(true, $settings['language_from_cdn']);
        $this->assertEmpty($settings['column_filter']);
    }
}
