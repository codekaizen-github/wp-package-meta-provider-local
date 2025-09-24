<?php
/**
 * FilePathSlugParser
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Parser;

use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\SlugParserContract;

/**
 * Undocumented class
 */
class FilePathSlugParser implements SlugParserContract {
	/**
	 * Undocumented variable
	 *
	 * @var string
	 */
	protected string $filePath;
	/**
	 * Undocumented variable
	 *
	 * @var string|null
	 */
	protected ?string $fullSlug;
	/**
	 * Undocumented variable
	 *
	 * @var string|null
	 */
	protected ?string $shortSlug;
	/**
	 * Undocumented function
	 *
	 * @param string $filePath File Path.
	 */
	public function __construct( string $filePath ) {
		$this->filePath  = $filePath;
		$this->fullSlug  = null;
		$this->shortSlug = null;
	}
	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	public function getShortSlug(): string {
		if ( null !== $this->fullSlug ) {
			return $this->fullSlug;
		}
		$basename = basename( $this->filePath );
		// Remove extension (if any) to get just the filename.
		$shortSlug       = pathinfo( $basename, PATHINFO_FILENAME );
		$this->shortSlug = $shortSlug;
		return $this->shortSlug;
	}
	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	public function getFullSlug(): string {
		if ( null === $this->fullSlug ) {
			$basename          = basename( $this->filePath );
			$directory         = dirname( $this->filePath );
			$directoryBasename = pathinfo( $directory, PATHINFO_BASENAME );
			// Includes any .php extension.
			$this->fullSlug = $directoryBasename . '/' . $basename;
		}
		return $this->fullSlug;
	}
}
