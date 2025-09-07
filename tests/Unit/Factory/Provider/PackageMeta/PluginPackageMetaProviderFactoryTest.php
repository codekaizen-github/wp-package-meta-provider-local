<?php
/**
 * Unit tests for PluginPackageMetaProviderFactory.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocalTests
 */

namespace CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Factory\Provider\PackageMeta;

use CodeKaizen\WPPackageMetaProviderLocal\Factory\Provider\PackageMeta\PluginPackageMetaProviderFactory;
use CodeKaizen\WPPackageMetaProviderLocalTests\Helper\FixturePathHelper;
use PHPUnit\Framework\TestCase;

/**
 * Unit test class for PluginPackageMetaProviderFactory.
 */
class PluginPackageMetaProviderFactoryTest extends TestCase {


	/**
	 * Tests that the provider returns the correct name for My Basics Plugin.
	 */
	public function testPluginPackageMetaMyBasicsPluginGetName(): void {
		$filePath = FixturePathHelper::getPathForPlugin() . '/my-basics-plugin.php';
		$factory  = new PluginPackageMetaProviderFactory( $filePath );
		$provider = $factory->create();
		$this->assertEquals( 'My Basics Plugin', $provider->getName() );
	}

	/**
	 * Tests that the provider returns the correct name for Minimum Headers Plugin.
	 */
	public function testPluginPackageMetaMinimumHeadersPluginGetName(): void {
		$filePath = FixturePathHelper::getPathForPlugin() . '/minimum-headers-plugin.php';
		$factory  = new PluginPackageMetaProviderFactory( $filePath );
		$provider = $factory->create();
		$this->assertEquals( 'Minimum Headers Plugin', $provider->getName() );
	}
}
