<?php
/**
 * Local Theme Package Meta Provider Test
 *
 * Tests for the provider that reads and extracts metadata from local theme files.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Provider\PackageMeta
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Provider\PackageMeta;

use CodeKaizen\WPPackageMetaProviderLocal\Contract\Accessor\AssociativeArrayStringToMixedAccessorContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Accessor\AssociativeArrayStringToStringAccessorContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\SlugParserContract;
use CodeKaizen\WPPackageMetaProviderLocal\Provider\PackageMeta\ThemePackageMetaProvider;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the theme package metadata provider implementation.
 *
 * @since 1.0.0
 */
class ThemePackageMetaProviderTest extends TestCase {

	/**
	 * Tests getName() extracts the correct plugin name from the My Basics plugin.
	 *
	 * @return void
	 */
	public function testGetNameFromThemeFabledSunset(): void {
		$response = [
			'Name'        => 'Test Theme',
			'ThemeURI'    => 'https://codekaizen.net',
			'Description' => 'This is a test theme',
			'Author'      => 'Andrew Dawes',
			'AuthorURI'   => 'https://codekaizen.net/team/andrew-dawes',
			'Version'     => '3.0.1',
			'Template'    => 'parent-theme',
			'Status'      => 'publish',
			'Tags'        => 'awesome,cool,test',
			'TextDomain'  => 'test-theme',
			'DomainPath'  => '/languages',
			'RequiresWP'  => '6.8.2',
			'RequiresPHP' => '8.2.1',
			'UpdateURI'   => 'https://github.com/codekaizen-github/wp-package-meta-provider-local',
		];
		$client   = Mockery::mock( AssociativeArrayStringToStringAccessorContract::class );
		$client->shouldReceive( 'get' )->with()->andReturn( $response );
		$slugParser = Mockery::mock( SlugParserContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( 'test-theme/style.css' );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( 'test-theme' );
		$provider = new ThemePackageMetaProvider( $slugParser, $client );
		$this->assertEquals( 'Test Theme', $provider->getName() );
	}
}
