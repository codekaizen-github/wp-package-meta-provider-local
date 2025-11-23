<?php
/**
 * Response Package Meta Array Assembler Test
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Assembler\Array\PackageMeta
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Tests\Unit\Assembler\Array\PackageMeta;

use CodeKaizen\WPPackageMetaProviderLocal\Assembler\Array\PackageMeta\StringPackageMetaArrayAssembler;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\StringToArrayStringByStringParserContract;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use TypeError;
use UnexpectedValueException;

/**
 * Undocumented class
 */
class StringPackageMetaArrayAssemblerTest extends TestCase {

	/**
	 * Undocumented variable
	 *
	 * @var (LoggerInterface&MockInterface)|null
	 */
	protected ?LoggerInterface $logger;


	/**
	 * Undocumented variable
	 *
	 * @var (StringToArrayStringByStringParserContract&MockInterface)|null
	 */
	protected ?StringToArrayStringByStringParserContract $parser;

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	protected function setUp(): void {
		$this->parser = Mockery::mock( StringToArrayStringByStringParserContract::class );
		$this->logger = Mockery::mock( LoggerInterface::class );
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
	 * @return StringToArrayStringByStringParserContract&MockInterface
	 */
	protected function getParser(): StringToArrayStringByStringParserContract&MockInterface {
		self::assertNotNull( $this->parser );
		return $this->parser;
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
	 * @return void
	 */
	public function testAssemblerInjectsContentInputAndReturnsParserOutput(): void {
		$content   = '';
		$metaArray = [
			'foo' => 'bar',
			'baz' => 'qux',
		];
		$parser    = $this->getParser();
		$parser->shouldReceive( 'parse' )->with( $content )->andReturn( $metaArray );
		$logger = $this->getLogger();
		$sut    = new StringPackageMetaArrayAssembler( $parser, $logger );
		$result = $sut->assemble( $content );
		$this->assertSame( $metaArray, $result );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function testAssemblerThrowsTypeErrorOnParserReturningNonArray(): void {
		$content = '';
		$parser  = $this->getParser();
		$parser->shouldReceive( 'parse' )->with( $content )->andReturn( 'not-an-array' );
		$logger = $this->getLogger();
		$sut    = new StringPackageMetaArrayAssembler( $parser, $logger );
		$this->expectException( TypeError::class );
		$sut->assemble( $content );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function testAssemblerThrowsUnexpectedValueExceptionOnParserReturningArrayWithNonStringKeys(): void {
		$content = '';
		$parser  = $this->getParser();
		$parser->shouldReceive( 'parse' )->with( $content )->andReturn( [ 123 => 'value' ] );
		$logger = $this->getLogger();
		$logger->shouldReceive( 'error' )->once();
		$sut = new StringPackageMetaArrayAssembler( $parser, $logger );
		$this->expectException( UnexpectedValueException::class );
		$sut->assemble( $content );
	}

		/**
		 * Undocumented function
		 *
		 * @return void
		 */
	public function testAssemblerThrowsUnexpectedValueExceptionOnParserReturningArrayWithNonStringValues(): void {
		$content = '';
		$parser  = $this->getParser();
		$parser->shouldReceive( 'parse' )->with( $content )->andReturn( [ 'asdf' => 123 ] );
		$logger = $this->getLogger();
		$logger->shouldReceive( 'error' )->once();
		$sut = new StringPackageMetaArrayAssembler( $parser, $logger );
		$this->expectException( UnexpectedValueException::class );
		$sut->assemble( $content );
	}
}
