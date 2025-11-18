<?php
/**
 * Local Plugin Package Meta Value Test
 *
 * Tests for the value that reads and extracts metadata from local plugin files.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Value\PackageMeta
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Value\PackageMeta;

use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use CodeKaizen\WPPackageMetaProviderLocal\Value\PackageMeta\PluginPackageMetaValue;

use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the plugin package metadata value implementation.
 *
 * @since 1.0.0
 */
class PluginPackageMetaValueTest extends TestCase {

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
		$iconsExpected                    = [];
		$bannersExpected                  = [];
		$bannersRTLExpected               = [];
		$networkActualRaw                 = 'true';
		$networkExpected                  = true;
		$requiresWordPressVersionExpected = '6.8.2';
		$requiresPHPVersionExpected       = '8.2.1';
		$downloadURLExpected              = 'https://github.com/codekaizen-github/wp-package-meta-sut-local';
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
		$slugParser                       = Mockery::mock( SlugValueContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( $fullSlugExpected );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( $shortSlugExpected );
		$sut = new PluginPackageMetaValue( $response, $slugParser );
		$this->assertEquals( $nameExpected, $sut->getName() );
		$this->assertEquals( $fullSlugExpected, $sut->getFullSlug() );
		$this->assertEquals( $shortSlugExpected, $sut->getShortSlug() );
		$this->assertEquals( $viewURLExpected, $sut->getViewURL() );
		$this->assertEquals( $versionExpected, $sut->getVersion() );
		$this->assertEquals( $shortDescriptionExpected, $sut->getShortDescription() );
		$this->assertEquals( $authorExpected, $sut->getAuthor() );
		$this->assertEquals( $authorURLExpected, $sut->getAuthorURL() );
		$this->assertEquals( $textDomainExpected, $sut->getTextDomain() );
		$this->assertEquals( $domainPathExpected, $sut->getDomainPath() );
		$this->assertEquals( $iconsExpected, $sut->getIcons() );
		$this->assertEquals( $bannersExpected, $sut->getBanners() );
		$this->assertEquals( $bannersRTLExpected, $sut->getBannersRTL() );
		$this->assertEquals( $networkExpected, $sut->getNetwork() );
		$this->assertEquals( $requiresWordPressVersionExpected, $sut->getRequiresWordPressVersion() );
		$this->assertEquals( $requiresPHPVersionExpected, $sut->getRequiresPHPVersion() );
		$this->assertEquals( $downloadURLExpected, $sut->getDownloadURL() );
		$this->assertEquals( $requiresPluginsExpected, $sut->getRequiresPlugins() );
		$this->assertEquals( $testedExpected, $sut->getTested() );
		$this->assertEquals( $stableExpected, $sut->getStable() );
		$this->assertEquals( $licenseExpected, $sut->getLicense() );
		$this->assertEquals( $licenseURLExpected, $sut->getLicenseURL() );
		$this->assertEquals( $descriptionExpected, $sut->getDescription() );
		$this->assertEquals( $tagsExpected, $sut->getTags() );
		$this->assertEquals( $sectionsExpected, $sut->getSections() );
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
		$iconsExpected                    = [];
		$bannersExpected                  = [];
		$bannersRTLExpected               = [];
		$networkActualRaw                 = 'true';
		$networkExpected                  = true;
		$requiresWordPressVersionExpected = '6.8.2';
		$requiresPHPVersionExpected       = '8.2.1';
		$downloadURLExpected              = 'https://github.com/codekaizen-github/wp-package-meta-sut-local';
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
		$slugParser                       = Mockery::mock( SlugValueContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( $fullSlugExpected );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( $shortSlugExpected );
		$sut = new PluginPackageMetaValue( $response, $slugParser );
		// phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
		$encoded = json_encode( $sut );
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
		$this->assertArrayHasKey( 'icons', $decoded );
		$this->assertEquals( $iconsExpected, $decoded['icons'] );
		$this->assertArrayHasKey( 'banners', $decoded );
		$this->assertEquals( $bannersExpected, $decoded['banners'] );
		$this->assertArrayHasKey( 'bannersRtl', $decoded );
		$this->assertEquals( $bannersRTLExpected, $decoded['bannersRtl'] );
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
	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function testBareMinimumFieldsValid(): void {
		$nameExpected                     = 'Test Plugin';
		$fullSlugExpected                 = 'test-plugin/test-plugin.php';
		$shortSlugExpected                = 'test-plugin';
		$viewURLExpected                  = null;
		$versionExpected                  = null;
		$downloadURLExpected              = null;
		$testedExpected                   = null;
		$stableExpected                   = null;
		$tagsExpected                     = [];
		$authorExpected                   = null;
		$authorURLExpected                = null;
		$licenseExpected                  = null;
		$licenseURLExpected               = null;
		$descriptionExpected              = null;
		$shortDescriptionExpected         = null;
		$requiresWordPressVersionExpected = null;
		$requiresPHPVersionExpected       = null;
		$textDomainExpected               = null;
		$domainPathExpected               = null;
		$iconsExpected                    = [];
		$bannersExpected                  = [];
		$bannersRtlExpected               = [];
		$tagsExpected                     = [];
		$sectionsExpected                 = [];
		$response                         = [
			'Name' => $nameExpected,
		];
		$slugParser                       = Mockery::mock( SlugValueContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( $fullSlugExpected );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( $shortSlugExpected );
		$sut = new PluginPackageMetaValue( $response, $slugParser );
		$this->assertEquals( $nameExpected, $sut->getName() );
		$this->assertEquals( $fullSlugExpected, $sut->getFullSlug() );
		$this->assertEquals( $shortSlugExpected, $sut->getShortSlug() );
		$this->assertEquals( $versionExpected, $sut->getVersion() );
		$this->assertEquals( $viewURLExpected, $sut->getViewURL() );
		$this->assertEquals( $downloadURLExpected, $sut->getDownloadURL() );
		$this->assertEquals( $testedExpected, $sut->getTested() );
		$this->assertEquals( $stableExpected, $sut->getStable() );
		$this->assertEquals( $tagsExpected, $sut->getTags() );
		$this->assertEquals( $authorExpected, $sut->getAuthor() );
		$this->assertEquals( $authorURLExpected, $sut->getAuthorURL() );
		$this->assertEquals( $licenseExpected, $sut->getLicense() );
		$this->assertEquals( $licenseURLExpected, $sut->getLicenseURL() );
		$this->assertEquals( $shortDescriptionExpected, $sut->getShortDescription() );
		$this->assertEquals( $descriptionExpected, $sut->getDescription() );
		$this->assertEquals( $requiresWordPressVersionExpected, $sut->getRequiresWordPressVersion() );
		$this->assertEquals( $requiresPHPVersionExpected, $sut->getRequiresPHPVersion() );
		$this->assertEquals( $textDomainExpected, $sut->getTextDomain() );
		$this->assertEquals( $domainPathExpected, $sut->getDomainPath() );
		$this->assertEquals( $iconsExpected, $sut->getIcons() );
		$this->assertEquals( $bannersExpected, $sut->getBanners() );
		$this->assertEquals( $bannersRtlExpected, $sut->getBannersRtl() );
		$this->assertEquals( $tagsExpected, $sut->getTags() );
		$this->assertEquals( $sectionsExpected, $sut->getSections() );
	}
}
