<?php
/**
 * Factory for StandardPluginPackageMetaValueService instances.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Factory\Service\Value\PackageMeta
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Factory\Service\Value\PackageMeta;

// phpcs:ignore Generic.Files.LineLength.TooLong
use CodeKaizen\WPPackageMetaProviderLocal\Factory\Service\Value\PackageMeta\Plugin\StandardPluginPackageMetaValueServiceFactory;
use CodeKaizen\WPPackageMetaProviderContract\Contract\Service\Value\PackageMeta\PluginPackageMetaValueServiceContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\String\MixedArrayStringAssemblerContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\String\StringMapStringParserContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Reader\ReaderContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Mockery;
use Mockery\MockInterface;

/**
 * Undocumented class
 */
class PluginPackageMetaValueServiceFactoryV1Test extends TestCase {

	/**
	 * Undocumented variable
	 *
	 * @var ?MockInterface
	 */
	protected ?MockInterface $assembler;

	/**
	 * Undocumented variable
	 *
	 * @var ?MockInterface
	 */
	protected ?MockInterface $reader;


	/**
	 * Undocumented variable
	 *
	 * @var (LoggerInterface&MockInterface)|null
	 */
	protected ?LoggerInterface $logger;

	/**
	 * Undocumented variable
	 *
	 * @var (SlugValueContract&MockInterface)|null
	 */
	protected ?SlugValueContract $slugValue;

	/**
	 * Undocumented variable
	 *
	 * @var ?MockInterface
	 */
	protected ?MockInterface $service;

	/**
	 * Undocumented function
	 *
	 * @var ?MockInterface
	 */
	protected ?MockInterface $parser;

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	protected function setUp(): void {
		// phpcs:disable Generic.Files.LineLength.TooLong
		$this->assembler = Mockery::mock(
			'overload:CodeKaizen\WPPackageMetaProviderLocal\Assembler\String\MixedArray\PackageMetaMixedArrayStringAssembler',
			'CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\String\MixedArrayStringAssemblerContract'
		);
		// phpcs:enable Generic.Files.LineLength.TooLong
		$this->reader    = Mockery::mock(
			'overload:CodeKaizen\WPPackageMetaProviderLocal\Reader\FileReader',
			'CodeKaizen\WPPackageMetaProviderLocal\Contract\Reader\ReaderContract'
		);
		$this->logger    = Mockery::mock( LoggerInterface::class );
		$this->slugValue = Mockery::mock( SlugValueContract::class );
		$this->parser    = Mockery::mock(
			'overload:CodeKaizen\WPPackageMetaProviderLocal\Parser\HeadersParser',
			'CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\String\StringMapStringParserContract'
		);
		// phpcs:disable Generic.Files.LineLength.TooLong
		$this->service = Mockery::mock(
			'overload:CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta\Plugin\StandardPluginPackageMetaValueService',
			'CodeKaizen\WPPackageMetaProviderContract\Contract\Service\Value\PackageMeta\PluginPackageMetaValueServiceContract'
		);
		// phpcs:enable Generic.Files.LineLength.TooLong
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
	 * @return MockInterface
	 */
	public function getAssembler(): MockInterface {
		self::assertNotNull( $this->assembler );
		return $this->assembler;
	}

	/**
	 * Undocumented function
	 *
	 * @return MockInterface
	 */
	public function getReader(): MockInterface {
		self::assertNotNull( $this->reader );
		return $this->reader;
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
	 * @return SlugValueContract&MockInterface
	 */
	protected function getSlugValue(): SlugValueContract&MockInterface {
		self::assertNotNull( $this->slugValue );
		return $this->slugValue;
	}

	/**
	 * Undocumented function
	 *
	 * @return MockInterface
	 */
	public function getParser(): MockInterface {
		self::assertNotNull( $this->parser );
		return $this->parser;
	}

	/**
	 * Undocumented function
	 *
	 * @return MockInterface
	 */
	public function getService(): MockInterface {
		self::assertNotNull( $this->service );
		return $this->service;
	}

	/**
	 * Undocumented function
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 * @return void
	 */
	public function testCreateReturnsServiceInstanceWithDefaults() {
		$filePath = '/path/to/meta/file';
		$sut      = new StandardPluginPackageMetaValueServiceFactory(
			$filePath,
			$this->getSlugValue(),
			$this->getLogger()
		);
		$this->getParser()->shouldReceive( '__construct' )
			->with(
				[
					'Name'            => 'Plugin Name',
					'PluginURI'       => 'Plugin URI',
					'Version'         => 'Version',
					'Description'     => 'Description',
					'Author'          => 'Author',
					'AuthorURI'       => 'Author URI',
					'TextDomain'      => 'Text Domain',
					'DomainPath'      => 'Domain Path',
					'Network'         => 'Network',
					'RequiresWP'      => 'Requires at least',
					'RequiresPHP'     => 'Requires PHP',
					'UpdateURI'       => 'Update URI',
					'RequiresPlugins' => 'Requires Plugins',
				]
			);
		$this->getAssembler()
			->shouldReceive( '__construct' )
			->withArgs(
				function ( ...$args ) {
					$this->assertInstanceOf( StringMapStringParserContract::class, $args[0] );
					$this->assertSame( $this->getLogger(), $args[1] );
					return true;
				}
			);
		$this->getReader()->shouldReceive( '__construct' )
			->with( $filePath );
		$this->getService()
			->shouldReceive( '__construct' )
			->withArgs(
				function ( ...$args ) {
					$this->assertInstanceOf( ReaderContract::class, $args[0] );
					$this->assertSame( $this->getSlugValue(), $args[1] );
					$this->assertInstanceOf( MixedArrayStringAssemblerContract::class, $args[2] );
					$this->assertSame( $this->getLogger(), $args[3] );
					return true;
				}
			);
		$service = $sut->create();
		$this->assertInstanceOf( PluginPackageMetaValueServiceContract::class, $service );
	}
}
