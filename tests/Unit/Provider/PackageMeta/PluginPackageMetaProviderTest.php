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
		$this->assertEquals( null, $provider->getTested() );
		$this->assertEquals( null, $provider->getStable() );
		$this->assertEquals( null, $provider->getLicense() );
		$this->assertEquals( null, $provider->getLicenseURL() );
		$this->assertEquals( null, $provider->getDescription() );
		$this->assertEquals( [], $provider->getTags() );
		$this->assertEquals( [], $provider->getSections() );
	}
}
