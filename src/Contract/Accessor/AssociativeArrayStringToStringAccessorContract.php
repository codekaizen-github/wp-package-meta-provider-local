<?php
/**
 * Interface for AssociativeArrayStringToMixedAccessorContract
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Contract\Accessor;

interface AssociativeArrayStringToStringAccessorContract {
	/**
	 * Gets data
	 *
	 * @return array<string,string>
	 */
	public function get(): array;
}
