<?php
/**
 * Test.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Service\Value\PackageMeta
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Service\Value\PackageMeta;

// phpcs:disable Generic.Files.LineLength -- Keep import on one line.
use CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta\ThemePackageMetaValueService;
use CodeKaizen\WPPackageMetaProviderContract\Contract\Value\PackageMeta\ThemePackageMetaValueContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\Array\PackageMeta\StringPackageMetaArrayAssemblerContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Reader\ReaderContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use CodeKaizen\WPPackageMetaProviderLocalTests\Helper\FixturePathHelper;
use PHPUnit\Framework\TestCase;
use Mockery;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;
use Mockery\MockInterface;

// phpcs:enable Generic.Files.LineLength
/**
 * Undocumented class
 */
class ThemePackageMetaValueServiceTest extends TestCase {

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
		$themeFilePath    = FixturePathHelper::getPathForTheme() . '/fabled-sunset/style.css';
		// phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$themeFileContents = file_get_contents( $themeFilePath );
		// phpcs:enable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$nameExpected                     = 'Fabled Sunset';
		$viewURLExpected                  = 'https://example.com/fabled-sunset';
		$versionExpected                  = '1.0.0';
		$shortDescriptionExpected         = 'Custom theme description...';
		$authorExpected                   = 'Your Name';
		$authorURLExpected                = 'https://example.com';
		$textDomainExpected               = 'fabled-sunset';
		$domainPathExpected               = '/assets/lang';
		$requiresWordPressVersionExpected = '6.2';
		$requiresPHPVersionExpected       = '7.2';
		$licenseURLExpected               = 'https://www.gnu.org/licenses/gpl-2.0.html';
		$tagsExpected                     = 'block-patterns, full-site-editing';
		$response                         = [
			'Name'        => $nameExpected,
			'ThemeURI'    => $viewURLExpected,
			'Description' => $shortDescriptionExpected,
			'Author'      => $authorExpected,
			'AuthorURI'   => $authorURLExpected,
			'Version'     => $versionExpected,
			'Tags'        => $tagsExpected,
			'TextDomain'  => $textDomainExpected,
			'DomainPath'  => $domainPathExpected,
			'RequiresWP'  => $requiresWordPressVersionExpected,
			'RequiresPHP' => $requiresPHPVersionExpected,
			'UpdateURI'   => $licenseURLExpected,
		];
		$this->getSlugValue()
			->shouldReceive( 'getFullSlug' )
			->byDefault()
			->andReturn( 'my-basics-theme/styloe.css' );
				$this->getSlugValue()
			->shouldReceive( 'getShortSlug' )
			->byDefault()
			->andReturn( 'my-basics-theme' );
		// phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$this->getReader()
			->shouldReceive( 'read' )
			->byDefault()
			->andReturn( $themeFileContents );
		// phpcs:enable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$this->assembler
			->shouldReceive( 'assemble' )
			->byDefault()
			->with( $themeFileContents )
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
		$sut = new ThemePackageMetaValueService( $this->getReader(), $this->getSlugValue(), $this->getAssembler(), $this->getLogger() );
		$this->assertInstanceOf( ThemePackageMetaValueContract::class, $sut->getPackageMeta() );
	}


	/**
	 * Test getPackageMeta does not cache the value.
	 */
	public function testGetPackageMetaDoesNotCacheValue(): void {
		$sut    = new ThemePackageMetaValueService( $this->getReader(), $this->getSlugValue(), $this->getAssembler(), $this->getLogger() );
		$first  = $sut->getPackageMeta();
		$second = $sut->getPackageMeta();
		$this->assertNotSame( $first, $second );
	}


	/**
	 * Test getPackageMeta throws on assembler exception.
	 */
	public function testGetPackageMetaThrowsOnAssemblerException(): void {
		$this->expectException( UnexpectedValueException::class );
		$badFileContents = 'This is not valid theme file contents.';
		$this->getReader()
			->shouldReceive( 'read' )
			->with()
			->andReturn( $badFileContents );
		$this
			->getAssembler()
			->shouldReceive( 'assemble' )
			->with( $badFileContents )
			->andThrow( new UnexpectedValueException( 'Invalid meta' ) );
		$sut = new ThemePackageMetaValueService(
			$this->getReader(),
			$this->getSlugValue(),
			$this->getAssembler(),
			$this->getLogger()
		);
		$sut->getPackageMeta();
	}
}
