<?php
/**
 * File Content Reader
 *
 * Provides a way to read the contents of a file.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Reader;

use CodeKaizen\WPPackageMetaProviderLocal\Contract\Accessor\StringAccessorContract;
use InvalidArgumentException;

/**
 * FileContentAccessor class implements the FileContentReaderContract interface.
 *
 * Reads content from files with size limits for performance.
 *
 * @since 1.0.0
 */
class FileContentAccessor implements StringAccessorContract {

	/**
	 * Undocumented variable
	 *
	 * @var string
	 */
	protected string $filePath;
	/**
	 * Undocumented function
	 *
	 * @param string $filePath Filepath.
	 * @throws InvalidArgumentException On invalid or inaccessible filepath.
	 */
	public function __construct( string $filePath ) {
		if ( ! file_exists( $filePath ) || ! is_readable( $filePath ) ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- Exception message not displayed to end users.
			throw new InvalidArgumentException( "Invalid or inaccessible file path: $filePath" );
		}
		$this->filePath = $filePath;
	}
	/**
	 * Reads content from a file.
	 *
	 * @return string The content of the file.
	 * @throws InvalidArgumentException If the file doesn't exist or is not readable.
	 */
	public function get(): string {
		$kbInBytes = 1024;
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Not in WordPress context.
		$fileData = file_get_contents( $this->filePath, false, null, 0, 8 * $kbInBytes );
		if ( false === $fileData ) {
			$fileData = '';
		}
		return $fileData;
	}
}
