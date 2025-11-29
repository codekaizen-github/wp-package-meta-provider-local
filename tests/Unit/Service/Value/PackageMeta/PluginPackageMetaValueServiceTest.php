<?php
/**
 * Test.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Service\Value\PackageMeta
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Service\Value\PackageMeta;

// phpcs:disable Generic.Files.LineLength -- Keep import on one line.
use CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta\Plugin\StandardPluginPackageMetaValueService;
use CodeKaizen\WPPackageMetaProviderContract\Contract\Value\PackageMeta\PluginPackageMetaValueContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\String\MixedArrayStringAssemblerContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Reader\ReaderContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use PHPUnit\Framework\TestCase;
use Mockery;
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
	 * @var (MixedArrayStringAssemblerContract&MockInterface)|null
	 */
	protected ?MixedArrayStringAssemblerContract $assembler;

	/**
	 * Undocumented variable
	 *
	 * @var (LoggerInterface&MockInterface)|null
	 */
	protected ?LoggerInterface $logger;


	/**
	 * Undocumented variable
	 *
	 * @var MockInterface
	 */
	protected MockInterface $packageMetaValue;

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	protected function setUp(): void {
		$this->slugParser       = Mockery::mock( SlugValueContract::class );
		$this->logger           = Mockery::mock( LoggerInterface::class );
		$this->reader           = Mockery::mock( ReaderContract::class );
		$this->assembler        = Mockery::mock( MixedArrayStringAssemblerContract::class );
		$this->packageMetaValue = Mockery::mock(
			'overload:CodeKaizen\WPPackageMetaProviderLocal\Value\PackageMeta\Plugin\StandardPluginPackageMetaValue',
			'CodeKaizen\WPPackageMetaProviderContract\Contract\Value\PackageMeta\PluginPackageMetaValueContract'
		);
		$this->getReader()->shouldReceive( 'read' )->byDefault();
		$this->getAssembler()->shouldReceive( 'assemble' )->byDefault();
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
	 * @return MixedArrayStringAssemblerContract&MockInterface
	 */
	protected function getAssembler(): MixedArrayStringAssemblerContract {
		self::assertNotNull( $this->assembler );
		return $this->assembler;
	}

	/**
	 * Undocumented function
	 *
	 * @return MockInterface
	 */
	protected function getPackageMetaValue(): MockInterface {
		return $this->packageMetaValue;
	}

	/**
	 * Test getPackageMeta returns value on success.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function testGetPackageMetaReturnsValueOnSuccess(): void {
		$sut = new StandardPluginPackageMetaValueService(
			$this->getReader(),
			$this->getSlugValue(),
			$this->getAssembler(),
			$this->getLogger()
		);
		$this->assertInstanceOf( PluginPackageMetaValueContract::class, $sut->getPackageMeta() );
	}


	/**
	 * Test getPackageMeta does not cache the value.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function testGetPackageMetaDoesNotCacheValue(): void {
		$sut    = new StandardPluginPackageMetaValueService(
			$this->getReader(),
			$this->getSlugValue(),
			$this->getAssembler(),
			$this->getLogger()
		);
		$first  = $sut->getPackageMeta();
		$second = $sut->getPackageMeta();
		$this->assertNotSame( $first, $second );
	}


	/**
	 * Test getPackageMeta throws on assembler exception.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function testGetPackageMetaThrowsOnAssemblerException(): void {
		$this->expectException( UnexpectedValueException::class );
		$this
			->getAssembler()
			->shouldReceive( 'assemble' )
			->andThrow( new UnexpectedValueException( 'Invalid meta' ) );
		$sut = new StandardPluginPackageMetaValueService(
			$this->getReader(),
			$this->getSlugValue(),
			$this->getAssembler(),
			$this->getLogger()
		);
		$sut->getPackageMeta();
	}

	/**
	 * Test assembler receives content from reader.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function testAssemblerReceivesContentFromReader(): void {
		$content = 'meta-content';
		$this->getReader()->shouldReceive( 'read' )->andReturn( $content );
		$this->getAssembler()->shouldReceive( 'assemble' )->andReturn( [] );
		$sut = new StandardPluginPackageMetaValueService(
			$this->getReader(),
			$this->getSlugValue(),
			$this->getAssembler(),
			$this->getLogger()
		);
		$sut->getPackageMeta();
	}

	/**
	 * Test package meta receives dependencies.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function testPackageMetaReceivesDependencies(): void {
		$assembled = [
			'key' => 'value',
		];
		$this->getAssembler()->shouldReceive( 'assemble' )->andReturn( $assembled );
		$this->getPackageMetaValue()->shouldReceive( '__construct' )->with(
			$assembled,
			$this->getSlugValue(),
			$this->getLogger()
		);
	}
}
