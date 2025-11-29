<?php
/**
 * Assembler
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Assembler\String\MixedArray;
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Assembler\String\MixedArray;

// phpcs:ignore Generic.Files.LineLength.TooLong
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\String\MixedArrayStringAssemblerContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\String\StringMapStringParserContract;
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
class PackageMetaMixedArrayStringAssembler implements MixedArrayStringAssemblerContract {

	/**
	 * Parser.
	 *
	 * @var StringMapStringParserContract
	 */
	protected StringMapStringParserContract $parser;
	/**
	 * Undocumented variable
	 *
	 * @var LoggerInterface
	 */
	protected LoggerInterface $logger;
	/**
	 * Constructor.
	 *
	 * @param StringMapStringParserContract $parser Parser.
	 * @param LoggerInterface               $logger Logger.
	 */
	public function __construct(
		StringMapStringParserContract $parser,
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
					new Rules\Call( 'array_keys', new Rules\Each( new Rules\StringType() ) ),
					new Rules\Call( 'array_values', new Rules\Each( new Rules\StringType() ) )
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
