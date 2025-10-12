<?php
/**
 * Test
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal
 */

namespace CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Factory\Provider\PackageMeta;

use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\SlugParserContract;
use CodeKaizen\WPPackageMetaProviderLocal\Factory\Provider\PackageMeta\PluginPackageMetaProviderFactoryV1;
use CodeKaizen\WPPackageMetaProviderLocalTests\Helper\FixturePathHelper;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Undocumented class
 */
class PluginPackageMetaProviderFactoryV1Test extends TestCase {
	/**
	 * Test create method.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 * @return void
	 */
	public function testCreate(): void {
		$filePath   = FixturePathHelper::getPathForPlugin() . '/minimum-headers-plugin.php';
		$slugParser = Mockery::mock( SlugParserContract::class );
		$logger     = Mockery::mock( LoggerInterface::class );
		Mockery::mock( 'overload:CodeKaizen\WPPackageMetaProviderLocal\Accessor\FileContentAccessor' );
		Mockery::mock( 'overload:CodeKaizen\WPPackageMetaProviderLocal\Accessor\SelectHeadersAccessor' );
		Mockery::mock(
			'overload:CodeKaizen\WPPackageMetaProviderLocal\Provider\PackageMeta\PluginPackageMetaProvider',
			'CodeKaizen\WPPackageMetaProviderContract\Contract\PluginPackageMetaContract'
		);
		$sut    = new PluginPackageMetaProviderFactoryV1( $filePath, $slugParser, $logger );
		$result = $sut->create();
		$this->assertInstanceOf(
			'CodeKaizen\WPPackageMetaProviderContract\Contract\PluginPackageMetaContract',
			$result
		);
	}
}
