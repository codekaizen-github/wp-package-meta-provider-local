<?php
/**
 * Local Theme Package Meta Value Test
 *
 * Tests for the value that reads and extracts metadata from local theme files.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Value\PackageMeta
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocalTests\Unit\Value\PackageMeta;

use CodeKaizen\WPPackageMetaProviderLocal\Value\PackageMeta\ThemePackageMetaValue;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the theme package metadata sut implementation.
 *
 * @since 1.0.0
 */
class ThemePackageMetaValueTest extends TestCase {

	/**
	 * Tests getName() extracts the correct plugin name from the My Basics plugin.
	 *
	 * @return void
	 */
	public function testAllPropertiesFromThemeFabledSunset(): void {
		$nameExpected                     = 'Test Theme';
		$fullSlugExpected                 = 'test-theme/style.css';
		$shortSlugExpected                = 'test-theme';
		$versionExpected                  = '3.0.1';
		$viewURLExpected                  = 'https://codekaizen.net';
		$downloadURLExpected              = 'https://github.com/codekaizen-github/wp-package-meta-sut-local';
		$tagsActualRaw                    = 'awesome,cool,test';
		$tagsExpected                     = [
			'awesome',
			'cool',
			'test',
		];
		$authorExpected                   = 'Andrew Dawes';
		$authorURLExpected                = 'https://codekaizen.net/team/andrew-dawes';
		$shortDescriptionExpected         = 'This is a test theme';
		$requiresWordPressVersionExpected = '6.8.2';
		$requiresPHPVersionExpected       = '8.2.1';
		$templateExpected                 = 'parent-theme';
		$statusExpected                   = 'publish';
		$textDomainExpected               = 'test-theme';
		$domainPathExpected               = '/languages';
		$iconsExpected                    = [];
		$bannersExpected                  = [];
		$bannersRTLExpected               = [];
		$testedExpected                   = null;
		$stableExpected                   = null;
		$licenseExpected                  = null;
		$licenseURLExpected               = null;
		$descriptionExpected              = null;
		$response                         = [
			'Name'        => $nameExpected,
			'ThemeURI'    => $viewURLExpected,
			'Description' => $shortDescriptionExpected,
			'Author'      => $authorExpected,
			'AuthorURI'   => $authorURLExpected,
			'Version'     => $versionExpected,
			'Template'    => $templateExpected,
			'Status'      => $statusExpected,
			'Tags'        => $tagsActualRaw,
			'TextDomain'  => $textDomainExpected,
			'DomainPath'  => $domainPathExpected,
			'RequiresWP'  => $requiresWordPressVersionExpected,
			'RequiresPHP' => $requiresPHPVersionExpected,
			'UpdateURI'   => $downloadURLExpected,
		];
		$slugParser                       = Mockery::mock( SlugValueContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( $fullSlugExpected );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( $shortSlugExpected );
		$sut = new ThemePackageMetaValue( $response, $slugParser );
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
		$this->assertEquals( $templateExpected, $sut->getTemplate() );
		$this->assertEquals( $statusExpected, $sut->getStatus() );
		$this->assertEquals( $textDomainExpected, $sut->getTextDomain() );
		$this->assertEquals( $domainPathExpected, $sut->getDomainPath() );
		$this->assertEquals( $iconsExpected, $sut->getIcons() );
		$this->assertEquals( $bannersExpected, $sut->getBanners() );
		$this->assertEquals( $bannersRTLExpected, $sut->getBannersRTL() );
	}
	/**
	 * Undocumented function.
	 *
	 * @return void
	 */
	public function testJSONEncodeAndDecode(): void {
		$nameExpected                     = 'Test Theme';
		$fullSlugExpected                 = 'test-theme/style.css';
		$shortSlugExpected                = 'test-theme';
		$versionExpected                  = '3.0.1';
		$viewURLExpected                  = 'https://codekaizen.net';
		$downloadURLExpected              = 'https://github.com/codekaizen-github/wp-package-meta-sut-local';
		$tagsActualRaw                    = 'awesome,cool,test';
		$tagsExpected                     = [
			'awesome',
			'cool',
			'test',
		];
		$authorExpected                   = 'Andrew Dawes';
		$authorURLExpected                = 'https://codekaizen.net/team/andrew-dawes';
		$shortDescriptionExpected         = 'This is a test theme';
		$requiresWordPressVersionExpected = '6.8.2';
		$requiresPHPVersionExpected       = '8.2.1';
		$templateExpected                 = 'parent-theme';
		$statusExpected                   = 'publish';
		$textDomainExpected               = 'test-theme';
		$domainPathExpected               = '/languages';
		$iconsExpected                    = [];
		$bannersExpected                  = [];
		$bannersRTLExpected               = [];
		$testedExpected                   = null;
		$stableExpected                   = null;
		$licenseExpected                  = null;
		$licenseURLExpected               = null;
		$descriptionExpected              = null;
		$response                         = [
			'Name'        => $nameExpected,
			'ThemeURI'    => $viewURLExpected,
			'Description' => $shortDescriptionExpected,
			'Author'      => $authorExpected,
			'AuthorURI'   => $authorURLExpected,
			'Version'     => $versionExpected,
			'Template'    => $templateExpected,
			'Status'      => $statusExpected,
			'Tags'        => $tagsActualRaw,
			'TextDomain'  => $textDomainExpected,
			'DomainPath'  => $domainPathExpected,
			'RequiresWP'  => $requiresWordPressVersionExpected,
			'RequiresPHP' => $requiresPHPVersionExpected,
			'UpdateURI'   => $downloadURLExpected,
		];
		$slugParser                       = Mockery::mock( SlugValueContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( $fullSlugExpected );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( $shortSlugExpected );
		$sut = new ThemePackageMetaValue( $response, $slugParser );
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
		$this->assertArrayHasKey( 'version', $decoded );
		$this->assertEquals( $versionExpected, $decoded['version'] );
		$this->assertArrayHasKey( 'viewUrl', $decoded );
		$this->assertEquals( $viewURLExpected, $decoded['viewUrl'] );
		$this->assertArrayHasKey( 'downloadUrl', $decoded );
		$this->assertEquals( $downloadURLExpected, $decoded['downloadUrl'] );
		$this->assertArrayHasKey( 'tested', $decoded );
		$this->assertEquals( $testedExpected, $decoded['tested'] );
		$this->assertArrayHasKey( 'stable', $decoded );
		$this->assertEquals( $stableExpected, $decoded['stable'] );
		$this->assertArrayHasKey( 'tags', $decoded );
		$this->assertEquals( $tagsExpected, $decoded['tags'] );
		$this->assertArrayHasKey( 'author', $decoded );
		$this->assertEquals( $authorExpected, $decoded['author'] );
		$this->assertArrayHasKey( 'authorUrl', $decoded );
		$this->assertEquals( $authorURLExpected, $decoded['authorUrl'] );
		$this->assertArrayHasKey( 'license', $decoded );
		$this->assertEquals( $licenseExpected, $decoded['license'] );
		$this->assertArrayHasKey( 'licenseUrl', $decoded );
		$this->assertEquals( $licenseURLExpected, $decoded['licenseUrl'] );
		$this->assertArrayHasKey( 'shortDescription', $decoded );
		$this->assertEquals( $shortDescriptionExpected, $decoded['shortDescription'] );
		$this->assertArrayHasKey( 'description', $decoded );
		$this->assertEquals( $descriptionExpected, $decoded['description'] );
		$this->assertArrayHasKey( 'requiresWordPressVersion', $decoded );
		$this->assertEquals( $requiresWordPressVersionExpected, $decoded['requiresWordPressVersion'] );
		$this->assertArrayHasKey( 'requiresPHPVersion', $decoded );
		$this->assertEquals( $requiresPHPVersionExpected, $decoded['requiresPHPVersion'] );
		$this->assertArrayHasKey( 'template', $decoded );
		$this->assertEquals( $templateExpected, $decoded['template'] );
		$this->assertArrayHasKey( 'status', $decoded );
		$this->assertEquals( $statusExpected, $decoded['status'] );
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
	}
	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function testBareMinimumFieldsValid(): void {
		$nameExpected                     = 'Test Theme';
		$fullSlugExpected                 = 'test-theme/style.css';
		$shortSlugExpected                = 'test-theme';
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
		$templateExpected                 = null;
		$statusExpected                   = null;
		$textDomainExpected               = null;
		$domainPathExpected               = null;
		$iconsExpected                    = [];
		$bannersExpected                  = [];
		$bannersRtlExpected               = [];
		$response                         = [
			'Name' => $nameExpected,
		];
		$slugParser                       = Mockery::mock( SlugValueContract::class );
		$slugParser->shouldReceive( 'getFullSlug' )->with()->andReturn( $fullSlugExpected );
		$slugParser->shouldReceive( 'getShortSlug' )->with()->andReturn( $shortSlugExpected );
		$sut = new ThemePackageMetaValue( $response, $slugParser );
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
		$this->assertEquals( $templateExpected, $sut->getTemplate() );
		$this->assertEquals( $statusExpected, $sut->getStatus() );
		$this->assertEquals( $textDomainExpected, $sut->getTextDomain() );
		$this->assertEquals( $domainPathExpected, $sut->getDomainPath() );
		$this->assertEquals( $iconsExpected, $sut->getIcons() );
		$this->assertEquals( $bannersExpected, $sut->getBanners() );
		$this->assertEquals( $bannersRtlExpected, $sut->getBannersRtl() );
	}
}
