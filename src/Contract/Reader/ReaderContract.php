<?php
/**
 * Reader Contract
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Contract\Reader
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Contract\Reader;

interface ReaderContract {
	/**
	 * Reads content.
	 *
	 * @return string The content.
	 */
	public function read(): string;
}
