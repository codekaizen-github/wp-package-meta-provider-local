<?php
/**
 * Test
 *
 * @package CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Factory\Provider\PackageMeta
 */

namespace CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Factory\Provider\PackageMeta;

use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\SlugParserContract;
use CodeKaizen\WPPackageMetaProviderLocal\Factory\Provider\PackageMeta\ThemePackageMetaProviderFactoryV1;
use CodeKaizen\WPPackageMetaProviderLocalTests\Helper\FixturePathHelper;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Undocumented class
 */
class ThemePackageMetaProviderFactoryV1Test extends TestCase {
	/**
	 * Test create method.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 * @return void
	 */
	public function testCreate(): void {
		$filePath   = FixturePathHelper::getPathForTheme() . '/minimum-headers-plugin.php';
		$slugParser = Mockery::mock( SlugParserContract::class );
		$logger     = Mockery::mock( LoggerInterface::class );
		Mockery::mock( 'overload:CodeKaizen\WPPackageMetaProviderLocal\Accessor\FileContentAccessor' );
		Mockery::mock( 'overload:CodeKaizen\WPPackageMetaProviderLocal\Accessor\SelectHeadersAccessor' );
		Mockery::mock(
			'overload:CodeKaizen\WPPackageMetaProviderLocal\Provider\PackageMeta\ThemePackageMetaProvider',
			'CodeKaizen\WPPackageMetaProviderContract\Contract\ThemePackageMetaContract'
		);
		$sut    = new ThemePackageMetaProviderFactoryV1( $filePath, $slugParser, $logger );
		$result = $sut->create();
		$this->assertInstanceOf(
			'CodeKaizen\WPPackageMetaProviderContract\Contract\ThemePackageMetaContract',
			$result
		);
	}
}
