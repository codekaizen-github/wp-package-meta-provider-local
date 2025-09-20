<?php
/**
 * Select Headers Package Meta Parser
 *
 * Parses file content to extract metadata from headers based on regex patterns.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Parser\PackageMeta;

use CodeKaizen\WPPackageMetaProviderORASHub\Contract\Accessor\AssociativeArrayStringToStringAccessorContract;
use CodeKaizen\WPPackageMetaProviderORASHub\Contract\Accessor\StringAccessorContract;
use UnexpectedValueException;

/**
 * Class for parsing package metadata from headers in file content.
 *
 * @since 1.0.0
 */
class SelectHeadersAccessor implements AssociativeArrayStringToStringAccessorContract {


	/**
	 * Undocumented variable
	 *
	 * @var StringAccessorContract
	 */
	protected StringAccessorContract $accessor;

	/**
	 * Headers to extract from content.
	 *
	 * @var array<string,string>
	 */
	private array $headers;

	/**
	 * Constructor.
	 *
	 * @param StringAccessorContract $accessor Accessor.
	 * @param array<string,string>   $headers Map of header field names to regex patterns.
	 */
	public function __construct( StringAccessorContract $accessor, array $headers = [] ) {
		$this->accessor = $accessor;
		$this->headers  = $headers;
	}

	/**
	 * Undocumented function
	 *
	 * @return array<string,string>
	 */
	public function get(): array {
		return $this->parse( $this->accessor->get() );
	}
	/**
	 * Parse the file contents to retrieve its metadata.
	 *
	 * Searches for metadata for a file, such as a plugin or theme.  Each piece of
	 * metadata must be on its own line. For a field spanning multiple lines, it
	 * must not have any newlines or only parts of it will be displayed.
	 *
	 * @param string $content The content to parse.
	 * @return array<string, string> Extracted header values.
	 */
	protected function parse( string $content ): array {

		// Make sure we catch CR-only line endings.
		$content    = str_replace( "\r", "\n", $content );
		$allHeaders = [];

		foreach ( $this->headers as $field => $regex ) {
			$pattern = '/^(?:[ \t]*<\?php)?[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi';
			if ( preg_match( $pattern, $content, $match ) && $match[1] ) {
				$allHeaders[ $field ] = $this->cleanUpHeaderComment( $match[1] );
			}
		}

		return $allHeaders;
	}
	/**
	 * Strips close comment and close php tags from file headers used by WP.
	 *
	 * @param string $str Header comment to clean up.
	 * @return string Cleaned header comment.
	 * @throws UnexpectedValueException If the header value is not a string.
	 */
	protected function cleanUpHeaderComment( $str ) {
		$replaced = preg_replace( '/\s*(?:\*\/|\?>).*/', '', $str );
		if ( ! is_string( $replaced ) ) {
			throw new UnexpectedValueException( 'Invalid header value. Value must be string.' );
		}
		return trim( $replaced );
	}
}
