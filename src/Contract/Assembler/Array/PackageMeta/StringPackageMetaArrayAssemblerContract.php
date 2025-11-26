<?php
/**
 * Interface for StringPackageMetaArrayAssemblerContract
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\Array\PackageMeta
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\Array\PackageMeta;

interface StringPackageMetaArrayAssemblerContract {
	/**
	 * Assembles package meta array from content.
	 *
	 * @param string $content Content.
	 * @return array<string,string>
	 */
	public function assemble( string $content ): array;
}
