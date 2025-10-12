<?php
/**
 * Interface for StringAccessorContract
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Contract\Accessor
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
