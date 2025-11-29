<?php
/**
 * Response Package Meta Array Assembler Test
 *
 * @package CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Assembler\String\MixedArray
 */

namespace CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Assembler\String\MixedArray;

use CodeKaizen\WPPackageMetaProviderLocal\Assembler\String\MixedArray\PackageMetaMixedArrayStringAssembler;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\String\StringMapStringParserContract;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use TypeError;
use UnexpectedValueException;

/**
 * Undocumented class
 */
class PackageMetaMixedArrayStringAssemblerTest extends TestCase {

	/**
	 * Undocumented variable
	 *
	 * @var (LoggerInterface&MockInterface)|null
	 */
	protected ?LoggerInterface $logger;


	/**
	 * Undocumented variable
	 *
	 * @var (StringMapStringParserContract&MockInterface)|null
	 */
	protected ?StringMapStringParserContract $parser;

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	protected function setUp(): void {
		$this->parser = Mockery::mock( StringMapStringParserContract::class );
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
	 * @return StringMapStringParserContract&MockInterface
	 */
	protected function getParser(): StringMapStringParserContract&MockInterface {
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
		$sut    = new PackageMetaMixedArrayStringAssembler( $parser, $logger );
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
		$sut    = new PackageMetaMixedArrayStringAssembler( $parser, $logger );
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
		$sut = new PackageMetaMixedArrayStringAssembler( $parser, $logger );
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
		$sut = new PackageMetaMixedArrayStringAssembler( $parser, $logger );
		$this->expectException( UnexpectedValueException::class );
		$sut->assemble( $content );
	}
}
