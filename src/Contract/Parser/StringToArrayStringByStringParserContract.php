<?php
/**
 * String to Array String By String Parser Contract
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser;

interface StringToArrayStringByStringParserContract {
	/**
	 * Parses a string into an array of strings using a specified delimiter.
	 *
	 * @param string $input The input string to be parsed.
	 * @return array<string, string> An array of strings obtained by splitting the input string.
	 */
	public function parse( string $input ): array;
}
