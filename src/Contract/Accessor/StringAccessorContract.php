<?php
/**
 * Interface for StringAccessorContract
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Contract\Accessor;

interface StringAccessorContract {
	/**
	 * Gets data
	 *
	 * @return string
	 */
	public function get(): string;
}
