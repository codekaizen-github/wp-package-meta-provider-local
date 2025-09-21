<?php
/**
 * Local Plugin Package Meta Provider Test
 *
 * Tests for the provider that reads and extracts metadata from local plugin files.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Provider\PackageMeta
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Provider\PackageMeta;

use CodeKaizen\WPPackageMetaProviderLocal\Contract\Accessor\AssociativeArrayStringToStringAccessorContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\SlugParserContract;
use CodeKaizen\WPPackageMetaProviderLocal\Provider\PackageMeta\PluginPackageMetaProvider;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the plugin package metadata provider implementation.
 *
 * @since 1.0.0
 */
class PluginPackageMetaProviderTest extends TestCase {

	/**
	 * Tests getName() extracts the correct plugin name from the My Basics plugin.
	 *
	 * @return void
	 */
	public function testGetNameFromPluginMyBasicsPlugin(): void {
		$response = [
			'Name'            => 'Test Plugin',
			'PluginURI'       => 'https://codekaizen.net',
			'Version'         => '3.0.1',
			'Description'     => 'This is a test plugin',
			'Author'          => 'Andrew Dawes',
			'AuthorURI'       => 'https://codekaizen.net/team/andrew-dawes',
			'TextDomain'      => 'test-plugin',
			'DomainPath'      => '/languages',
			'Network'         => 'true',
			'RequiresWP'      => '6.8.2',
			'RequiresPHP'     => '8.2.1',
			'UpdateURI'       => 'https://github.com/codekaizen-github/wp-package-meta-provider-local',
			'RequiresPlugins' => 'akismet,hello-dolly',
		];
		$client   = Mockery::mock( AssociativeArrayStringToStringAccessorContract::class );
		$client->shouldReceive( 'get' )->with()->andReturn( $response );
		$slugParser = Mockery::mock( SlugParserContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( 'test-plugin/test-plugin.php' );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( 'test-plugin' );
		$provider = new PluginPackageMetaProvider( $slugParser, $client );
		$this->assertEquals( 'Test Plugin', $provider->getName() );
	}
}
