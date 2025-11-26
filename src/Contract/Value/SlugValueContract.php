<?php
/**
 * Slug Value Contract
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Contract\Value
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Contract\Value;

interface SlugValueContract {
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
