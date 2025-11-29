<?php
/**
 * Interface for MixedArrayStringAssemblerContract
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\String
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\String;

interface MixedArrayStringAssemblerContract {
	/**
	 * Assembles package meta array from content.
	 *
	 * @param string $content Content.
	 * @return array<string,string>
	 */
	public function assemble( string $content ): array;
}
