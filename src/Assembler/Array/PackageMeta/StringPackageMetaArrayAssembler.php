<?php
/**
 * Assembler
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Assembler\Array\PackageMeta;
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Assembler\Array\PackageMeta;

// phpcs:ignore Generic.Files.LineLength.TooLong
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\Array\PackageMeta\StringPackageMetaArrayAssemblerContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\StringToArrayStringByStringParserContract;
// phpcs:ignore Generic.Files.LineLength.TooLong
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Respect\Validation\Validator;
use Respect\Validation\Rules;
use Respect\Validation\Exceptions\ValidationException;
use UnexpectedValueException;

/**
 * Class to assemble package meta from response
 */
class StringPackageMetaArrayAssembler implements StringPackageMetaArrayAssemblerContract {

	/**
	 * Parser.
	 *
	 * @var StringToArrayStringByStringParserContract
	 */
	protected StringToArrayStringByStringParserContract $parser;
	/**
	 * Undocumented variable
	 *
	 * @var LoggerInterface
	 */
	protected LoggerInterface $logger;
	/**
	 * Constructor.
	 *
	 * @param StringToArrayStringByStringParserContract $parser Parser.
	 * @param LoggerInterface                           $logger Logger.
	 */
	public function __construct(
		StringToArrayStringByStringParserContract $parser,
		LoggerInterface $logger = new NullLogger()
	) {
		$this->parser = $parser;
		$this->logger = $logger;
	}
	/**
	 * Values will have been validated
	 *
	 * @param string $content Content.
	 * @return array<string,string> $metaDecoded
	 * @throws UnexpectedValueException If the content cannot be decoded.
	 */
	public function assemble( string $content ): array {
		$parsed = $this->parser->parse( $content );
		try {
			Validator::create(
				new Rules\AllOf(
					new Rules\ArrayType(),
					new Rules\Call( 'array_keys', new Rules\Each( new Rules\StringType() ) )
				)
			)->check( $parsed );
		} catch ( ValidationException $e ) {
			$this->logger->error(
				'Failed to assemble package meta array from content: {message}',
				[
					'exception' => $e,
					'parsed'    => $parsed,
				]
			);
			// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- Exception message not displayed to end users.
			throw new UnexpectedValueException( $e->getMessage() );
		}
		/**
		 * Validated.
		 *
		 * @var array<string,string> $parsed
		 */
		return $parsed;
	}
}
