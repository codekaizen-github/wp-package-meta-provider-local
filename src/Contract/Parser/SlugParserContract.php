<?php
/**
 * SlugParser
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser;

interface SlugParserContract {
	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	public function getFullSlug(): string;
	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	public function getShortSlug(): string;
}
