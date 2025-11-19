<?php
/**
 * Test.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Service\Value\PackageMeta
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Service\Value\PackageMeta;

// phpcs:disable Generic.Files.LineLength -- Keep import on one line.
use CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta\PluginPackageMetaValueService;
use CodeKaizen\WPPackageMetaProviderContract\Contract\Value\PackageMeta\PluginPackageMetaValueContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\Array\PackageMeta\StringPackageMetaArrayAssemblerContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Reader\ReaderContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use CodeKaizen\WPPackageMetaProviderLocalTests\Helper\FixturePathHelper;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Mockery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;
use Mockery\MockInterface;

// phpcs:enable Generic.Files.LineLength
/**
 * Undocumented class
 */
class PluginPackageMetaValueServiceTest extends TestCase {

	/**
	 * Undocumented variable
	 *
	 * @var (SlugValueContract&MockInterface)|null
	 */
	protected ?SlugValueContract $slugParser;

	/**
	 * Undocumented variable
	 *
	 * @var (ReaderContract&MockInterface)|null
	 */
	protected ?ReaderContract $reader;

	/**
	 * Undocumented variable
	 *
	 * @var (StringPackageMetaArrayAssemblerContract&MockInterface)|null
	 */
	protected ?StringPackageMetaArrayAssemblerContract $assembler;

	/**
	 * Undocumented variable
	 *
	 * @var (LoggerInterface&MockInterface)|null
	 */
	protected ?LoggerInterface $logger;

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	protected function setUp(): void {
		$this->slugParser = Mockery::mock( SlugValueContract::class );
		$this->logger     = Mockery::mock( LoggerInterface::class );
		$this->reader     = Mockery::mock( ReaderContract::class );
		$this->assembler  = Mockery::mock( StringPackageMetaArrayAssemblerContract::class );
		$pluginFilePath   = FixturePathHelper::getPathForPlugin() . '/my-basics-plugin.php';
		// phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$pluginFileContents = file_get_contents( $pluginFilePath );
		// phpcs:enable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$nameExpected                     = 'My Basics Plugin';
		$viewURLExpected                  = 'https://example.com/plugins/the-basics/';
		$versionExpected                  = '1.10.3';
		$shortDescriptionExpected         = 'Handle the basics with this plugin.';
		$authorExpected                   = 'John Smith';
		$authorURLExpected                = 'https://author.example.com/';
		$textDomainExpected               = 'my-basics-plugin';
		$domainPathExpected               = '/languages';
		$networkActualRaw                 = '';
		$requiresWordPressVersionExpected = '5.2';
		$requiresPHPVersionExpected       = '7.2';
		$downloadURLExpected              = 'https://example.com/my-plugin/';
		$requiresPluginsActualRaw         = 'my-plugin, yet-another-plugin';
		$response                         = [
			'Name'            => $nameExpected,
			'PluginURI'       => $viewURLExpected,
			'Version'         => $versionExpected,
			'Description'     => $shortDescriptionExpected,
			'Author'          => $authorExpected,
			'AuthorURI'       => $authorURLExpected,
			'TextDomain'      => $textDomainExpected,
			'DomainPath'      => $domainPathExpected,
			'Network'         => $networkActualRaw,
			'RequiresWP'      => $requiresWordPressVersionExpected,
			'RequiresPHP'     => $requiresPHPVersionExpected,
			'UpdateURI'       => $downloadURLExpected,
			'RequiresPlugins' => $requiresPluginsActualRaw,
		];
		$this->getSlugValue()
			->shouldReceive( 'getFullSlug' )
			->byDefault()
			->andReturn( 'my-basics-plugin/my-basics-plugin.php' );
				$this->getSlugValue()
			->shouldReceive( 'getShortSlug' )
			->byDefault()
			->andReturn( 'my-basics-plugin' );
		// phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$this->getReader()
			->shouldReceive( 'read' )
			->byDefault()
			->andReturn( $pluginFileContents );
		// phpcs:enable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$this->assembler
			->shouldReceive( 'assemble' )
			->byDefault()
			->with( $pluginFileContents )
			->andReturn( $response );
		// $this->logger->shouldReceive( 'debug' )->byDefault();
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	protected function tearDown(): void {
		Mockery::close();
	}

	/**
	 * Undocumented function
	 *
	 * @return SlugValueContract&MockInterface
	 */
	protected function getSlugValue(): SlugValueContract&MockInterface {
		self::assertNotNull( $this->slugParser );
		return $this->slugParser;
	}


	/**
	 * Undocumented function
	 *
	 * @return LoggerInterface&MockInterface
	 */
	protected function getLogger(): LoggerInterface&MockInterface {
		self::assertNotNull( $this->logger );
		return $this->logger;
	}


	/**
	 * Undocumented function
	 *
	 * @return ReaderContract&MockInterface
	 */
	protected function getReader(): ReaderContract&MockInterface {
		self::assertNotNull( $this->reader );
		return $this->reader;
	}

	/**
	 * Undocumented function
	 *
	 * @return StringPackageMetaArrayAssemblerContract&MockInterface
	 */
	protected function getAssembler(): StringPackageMetaArrayAssemblerContract {
		self::assertNotNull( $this->assembler );
		return $this->assembler;
	}

	/**
	 * Test getPackageMeta returns value on success.
	 */
	public function testGetPackageMetaReturnsValueOnSuccess(): void {
		$sut = new PluginPackageMetaValueService( $this->getReader(), $this->getSlugValue(), $this->getAssembler(), $this->getLogger() );
		$this->assertInstanceOf( PluginPackageMetaValueContract::class, $sut->getPackageMeta() );
	}


	/**
	 * Test getPackageMeta does not cache the value.
	 */
	public function testGetPackageMetaDoesNotCacheValue(): void {
		$sut    = new PluginPackageMetaValueService( $this->getReader(), $this->getSlugValue(), $this->getAssembler(), $this->getLogger() );
		$first  = $sut->getPackageMeta();
		$second = $sut->getPackageMeta();
		$this->assertNotSame( $first, $second );
	}


	/**
	 * Test getPackageMeta throws on assembler exception.
	 */
	public function testGetPackageMetaThrowsOnAssemblerException(): void {
		$this->expectException( UnexpectedValueException::class );
		$badFileContents = 'This is not valid plugin file contents.';
		$this->getReader()
			->shouldReceive( 'read' )
			->with()
			->andReturn( $badFileContents );
		$this
			->getAssembler()
			->shouldReceive( 'assemble' )
			->with( $badFileContents )
			->andThrow( new UnexpectedValueException( 'Invalid meta' ) );
		$sut = new PluginPackageMetaValueService(
			$this->getReader(),
			$this->getSlugValue(),
			$this->getAssembler(),
			$this->getLogger()
		);
		$sut->getPackageMeta();
	}
}
