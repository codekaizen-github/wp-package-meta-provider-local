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
	public function testAllPropertiesFromPluginMyBasicsPlugin(): void {
		$nameExpected                     = 'Test Plugin';
		$fullSlugExpected                 = 'test-plugin/test-plugin.php';
		$shortSlugExpected                = 'test-plugin';
		$viewURLExpected                  = 'https://codekaizen.net';
		$versionExpected                  = '3.0.1';
		$shortDescriptionExpected         = 'This is a test plugin';
		$authorExpected                   = 'Andrew Dawes';
		$authorURLExpected                = 'https://codekaizen.net/team/andrew-dawes';
		$textDomainExpected               = 'test-plugin';
		$domainPathExpected               = '/languages';
		$networkActualRaw                 = 'true';
		$networkExpected                  = true;
		$requiresWordPressVersionExpected = '6.8.2';
		$requiresPHPVersionExpected       = '8.2.1';
		$downloadURLExpected              = 'https://github.com/codekaizen-github/wp-package-meta-provider-local';
		$requiresPluginsActualRaw         = 'akismet,hello-dolly';
		$requiresPluginsExpected          = [ 'akismet', 'hello-dolly' ];
		$testedExpected                   = null;
		$stableExpected                   = null;
		$licenseExpected                  = null;
		$licenseURLExpected               = null;
		$descriptionExpected              = null;
		$tagsExpected                     = [];
		$sectionsExpected                 = [];
		$response                         = [
			'Name'            => $nameExpected,
			'PluginURI'       => $viewURLExpected,
			'Version'         => $versionExpected,
			'Description'     => $shortDescriptionExpected,
			'Author'          => $authorExpected,
			'AuthorURI'       => $authorURLExpected,
			'TextDomain'      => $textDomainExpected,
			'DomainPath'      => $domainPathExpected,
			'Network'         => $networkActualRaw,
			'RequiresWP'      => $requiresWordPressVersionExpected,
			'RequiresPHP'     => $requiresPHPVersionExpected,
			'UpdateURI'       => $downloadURLExpected,
			'RequiresPlugins' => $requiresPluginsActualRaw,
		];
		$client                           = Mockery::mock( AssociativeArrayStringToStringAccessorContract::class );
		$client->shouldReceive( 'get' )->with()->andReturn( $response );
		$slugParser = Mockery::mock( SlugParserContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( $fullSlugExpected );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( $shortSlugExpected );
		$provider = new PluginPackageMetaProvider( $slugParser, $client );
		$this->assertEquals( $nameExpected, $provider->getName() );
		$this->assertEquals( $fullSlugExpected, $provider->getFullSlug() );
		$this->assertEquals( $shortSlugExpected, $provider->getShortSlug() );
		$this->assertEquals( $viewURLExpected, $provider->getViewURL() );
		$this->assertEquals( $versionExpected, $provider->getVersion() );
		$this->assertEquals( $shortDescriptionExpected, $provider->getShortDescription() );
		$this->assertEquals( $authorExpected, $provider->getAuthor() );
		$this->assertEquals( $authorURLExpected, $provider->getAuthorURL() );
		$this->assertEquals( $textDomainExpected, $provider->getTextDomain() );
		$this->assertEquals( $domainPathExpected, $provider->getDomainPath() );
		$this->assertEquals( $networkExpected, $provider->getNetwork() );
		$this->assertEquals( $requiresWordPressVersionExpected, $provider->getRequiresWordPressVersion() );
		$this->assertEquals( $requiresPHPVersionExpected, $provider->getRequiresPHPVersion() );
		$this->assertEquals( $downloadURLExpected, $provider->getDownloadURL() );
		$this->assertEquals( $requiresPluginsExpected, $provider->getRequiresPlugins() );
		$this->assertEquals( $testedExpected, $provider->getTested() );
		$this->assertEquals( $stableExpected, $provider->getStable() );
		$this->assertEquals( $licenseExpected, $provider->getLicense() );
		$this->assertEquals( $licenseURLExpected, $provider->getLicenseURL() );
		$this->assertEquals( $descriptionExpected, $provider->getDescription() );
		$this->assertEquals( $tagsExpected, $provider->getTags() );
		$this->assertEquals( $sectionsExpected, $provider->getSections() );
	}
	/**
	 * Test
	 *
	 * @return void
	 */
	public function testJSONEncodeAndDecode(): void {

		$nameExpected                     = 'Test Plugin';
		$fullSlugExpected                 = 'test-plugin/test-plugin.php';
		$shortSlugExpected                = 'test-plugin';
		$viewURLExpected                  = 'https://codekaizen.net';
		$versionExpected                  = '3.0.1';
		$shortDescriptionExpected         = 'This is a test plugin';
		$authorExpected                   = 'Andrew Dawes';
		$authorURLExpected                = 'https://codekaizen.net/team/andrew-dawes';
		$textDomainExpected               = 'test-plugin';
		$domainPathExpected               = '/languages';
		$networkActualRaw                 = 'true';
		$networkExpected                  = true;
		$requiresWordPressVersionExpected = '6.8.2';
		$requiresPHPVersionExpected       = '8.2.1';
		$downloadURLExpected              = 'https://github.com/codekaizen-github/wp-package-meta-provider-local';
		$requiresPluginsActualRaw         = 'akismet,hello-dolly';
		$requiresPluginsExpected          = [ 'akismet', 'hello-dolly' ];
		$testedExpected                   = null;
		$stableExpected                   = null;
		$licenseExpected                  = null;
		$licenseURLExpected               = null;
		$descriptionExpected              = null;
		$tagsExpected                     = [];
		$sectionsExpected                 = [];
		$response                         = [
			'Name'            => $nameExpected,
			'PluginURI'       => $viewURLExpected,
			'Version'         => $versionExpected,
			'Description'     => $shortDescriptionExpected,
			'Author'          => $authorExpected,
			'AuthorURI'       => $authorURLExpected,
			'TextDomain'      => $textDomainExpected,
			'DomainPath'      => $domainPathExpected,
			'Network'         => $networkActualRaw,
			'RequiresWP'      => $requiresWordPressVersionExpected,
			'RequiresPHP'     => $requiresPHPVersionExpected,
			'UpdateURI'       => $downloadURLExpected,
			'RequiresPlugins' => $requiresPluginsActualRaw,
		];
		$client                           = Mockery::mock( AssociativeArrayStringToStringAccessorContract::class );
		$client->shouldReceive( 'get' )->with()->andReturn( $response );
		$slugParser = Mockery::mock( SlugParserContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( $fullSlugExpected );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( $shortSlugExpected );
		$provider = new PluginPackageMetaProvider( $slugParser, $client );
		// phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
		$encoded = json_encode( $provider );
		$this->assertIsString( $encoded );
		$decoded = json_decode( $encoded, true );
		$this->assertIsArray( $decoded );
		$this->assertArrayHasKey( 'name', $decoded );
		$this->assertEquals( $nameExpected, $decoded['name'] );
		$this->assertArrayHasKey( 'fullSlug', $decoded );
		$this->assertEquals( $fullSlugExpected, $decoded['fullSlug'] );
		$this->assertArrayHasKey( 'shortSlug', $decoded );
		$this->assertEquals( $shortSlugExpected, $decoded['shortSlug'] );
		$this->assertArrayHasKey( 'viewUrl', $decoded );
		$this->assertEquals( $viewURLExpected, $decoded['viewUrl'] );
		$this->assertArrayHasKey( 'version', $decoded );
		$this->assertEquals( $versionExpected, $decoded['version'] );
		$this->assertArrayHasKey( 'shortDescription', $decoded );
		$this->assertEquals( $shortDescriptionExpected, $decoded['shortDescription'] );
		$this->assertArrayHasKey( 'author', $decoded );
		$this->assertEquals( $authorExpected, $decoded['author'] );
		$this->assertArrayHasKey( 'authorUrl', $decoded );
		$this->assertEquals( $authorURLExpected, $decoded['authorUrl'] );
		$this->assertArrayHasKey( 'textDomain', $decoded );
		$this->assertEquals( $textDomainExpected, $decoded['textDomain'] );
		$this->assertArrayHasKey( 'domainPath', $decoded );
		$this->assertEquals( $domainPathExpected, $decoded['domainPath'] );
		$this->assertArrayHasKey( 'network', $decoded );
		$this->assertEquals( $networkExpected, $decoded['network'] );
		$this->assertArrayHasKey( 'requiresWordPressVersion', $decoded );
		$this->assertEquals( $requiresWordPressVersionExpected, $decoded['requiresWordPressVersion'] );
		$this->assertArrayHasKey( 'requiresPHPVersion', $decoded );
		$this->assertEquals( $requiresPHPVersionExpected, $decoded['requiresPHPVersion'] );
		$this->assertArrayHasKey( 'downloadUrl', $decoded );
		$this->assertEquals( $downloadURLExpected, $decoded['downloadUrl'] );
		$this->assertArrayHasKey( 'requiresPlugins', $decoded );
		$this->assertEquals( $requiresPluginsExpected, $decoded['requiresPlugins'] );
		$this->assertArrayHasKey( 'tested', $decoded );
		$this->assertEquals( $testedExpected, $decoded['tested'] );
		$this->assertArrayHasKey( 'stable', $decoded );
		$this->assertEquals( $stableExpected, $decoded['stable'] );
		$this->assertArrayHasKey( 'license', $decoded );
		$this->assertEquals( $licenseExpected, $decoded['license'] );
		$this->assertArrayHasKey( 'licenseUrl', $decoded );
		$this->assertEquals( $licenseURLExpected, $decoded['licenseUrl'] );
		$this->assertArrayHasKey( 'description', $decoded );
		$this->assertEquals( $descriptionExpected, $decoded['description'] );
		$this->assertArrayHasKey( 'tags', $decoded );
		$this->assertEquals( $tagsExpected, $decoded['tags'] );
		$this->assertArrayHasKey( 'sections', $decoded );
		$this->assertEquals( $sectionsExpected, $decoded['sections'] );
	}
}
