<?php
/**
 * Local Plugin Package Meta Provider
 *
 * Provides metadata for WordPress plugins installed locally.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Value\PackageMeta
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Value\PackageMeta;

use CodeKaizen\WPPackageMetaProviderContract\Contract\Value\PackageMeta\PluginPackageMetaValueContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use Respect\Validation\Validator;
use CodeKaizen\WPPackageMetaProviderLocal\Validator\Rule\PackageMeta\PluginHeadersArrayRule;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;
use UnexpectedValueException;

/**
 * Provider for local WordPress plugin package metadata.
 *
 * Reads and parses metadata from plugin files in the local filesystem.
 *
 * @since 1.0.0
 */
class PluginPackageMetaValue implements PluginPackageMetaValueContract {

	/**
	 * Logger.
	 *
	 * @var LoggerInterface
	 */
	protected LoggerInterface $logger;

	/**
	 * Undocumented variable
	 *
	 * @var SlugValueContract
	 */
	protected SlugValueContract $slugParser;

	/**
	 * Cached package metadata.
	 *
	 * @var array<string,string>
	 */
	protected array $packageMeta;
	/**
	 * Constructor.
	 *
	 * @param array<string,string> $packageMeta Data.
	 * @param SlugValueContract    $slugParser Slug data.
	 * @param LoggerInterface      $logger Logger.
	 *
	 * @throws UnexpectedValueException If the metadata is invalid.
	 */
	public function __construct(
		array $packageMeta,
		SlugValueContract $slugParser,
		LoggerInterface $logger = new NullLogger()
	) {
		$this->logger = $logger;
		try {
			Validator::create( new PluginHeadersArrayRule() )->check( $packageMeta );
		} catch ( Throwable $e ) {
			$this->logger->error(
				'Failed to validate plugin metadata.',
				[
					'exception'   => $e,
					'packageMeta' => $packageMeta,
				]
			);
			// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- Exception message not displayed to end users.
			throw new UnexpectedValueException( 'Invalid plugin metadata.', 0, $e );
		}
		$this->packageMeta = $packageMeta;
		$this->slugParser  = $slugParser;
	}
		/**
		 * Gets the name of the plugin.
		 *
		 * @return string The plugin name.
		 */
	public function getName(): string {
		return $this->getPackageMeta()['Name'];
	}
	/**
	 * Full slug, including any directory prefix and any file extension like .php - may contain a "/".
	 *
	 * @return string
	 */
	public function getFullSlug(): string {
		return $this->slugParser->getFullSlug();
	}
	/**
	 * Slug minus any prefix. Should not contain a "/".
	 *
	 * @return string
	 */
	public function getShortSlug(): string {
		return $this->slugParser->getShortSlug();
	}
	/**
	 * Gets the version of the plugin.
	 *
	 * @return ?string The plugin version or null if not available.
	 */
	public function getVersion(): ?string {
		return $this->getPackageMeta()['Version'] ?? null;
	}
	/**
	 * Gets the plugin URI.
	 *
	 * @return ?string The plugin URI or null if not available.
	 */
	public function getViewURL(): ?string {
		return $this->getPackageMeta()['PluginURI'] ?? null;
	}
	/**
	 * Gets the download URL for the plugin.
	 *
	 * @return ?string The plugin download URL or null if not available.
	 */
	public function getDownloadURL(): ?string {
		return $this->getPackageMeta()['UpdateURI'] ?? null;
	}
	/**
	 * Gets the WordPress version the plugin has been tested with.
	 *
	 * @return ?string Tested WordPress version or null if not available.
	 */
	public function getTested(): ?string {
		return null;
	}
	/**
	 * Gets the stable version of the plugin.
	 *
	 * @return ?string The stable version or null if not available.
	 */
	public function getStable(): ?string {
		return null;
	}
	/**
	 * Gets the plugin tags.
	 *
	 * @return string[] Array of plugin tags.
	 */
	public function getTags(): array {
		return [];
	}
	/**
	 * Gets the plugin author.
	 *
	 * @return ?string The plugin author or null if not available.
	 */
	public function getAuthor(): ?string {
		return $this->getPackageMeta()['Author'] ?? null;
	}
	/**
	 * Gets the plugin author's URL.
	 *
	 * @return ?string The plugin author's URL or null if not available.
	 */
	public function getAuthorURL(): ?string {
		return $this->getPackageMeta()['AuthorURI'] ?? null;
	}
	/**
	 * Gets the plugin license.
	 *
	 * @return ?string The plugin license or null if not available.
	 */
	public function getLicense(): ?string {
		return null;
	}
	/**
	 * Gets the plugin license URL.
	 *
	 * @return ?string The plugin license URL or null if not available.
	 */
	public function getLicenseURL(): ?string {
		return null;
	}
	/**
	 * Gets the short description of the plugin.
	 *
	 * @return ?string The plugin short description or null if not available.
	 */
	public function getShortDescription(): ?string {
		return $this->getPackageMeta()['Description'] ?? null;
	}
	/**
	 * Gets the full description of the plugin.
	 *
	 * @return ?string The plugin full description or null if not available.
	 */
	public function getDescription(): ?string {
		return null;
	}
	/**
	 * Gets the minimum WordPress version required by the plugin.
	 *
	 * @return ?string The required WordPress version or null if not specified.
	 */
	public function getRequiresWordPressVersion(): ?string {
		return $this->getPackageMeta()['RequiresWP'] ?? null;
	}
	/**
	 * Gets the minimum PHP version required by the plugin.
	 *
	 * @return ?string The required PHP version or null if not specified.
	 */
	public function getRequiresPHPVersion(): ?string {
		return $this->getPackageMeta()['RequiresPHP'] ?? null;
	}
	/**
	 * Gets the text domain used by the plugin for internationalization.
	 *
	 * @return ?string The text domain or null if not specified.
	 */
	public function getTextDomain(): ?string {
		return $this->getPackageMeta()['TextDomain'] ?? null;
	}
	/**
	 * Gets the domain path for the plugin's translation files.
	 *
	 * @return ?string The domain path or null if not specified.
	 */
	public function getDomainPath(): ?string {
		return $this->getPackageMeta()['DomainPath'] ?? null;
	}
	/**
	 * Gets the icons for the theme.
	 *
	 * @return array<string,string> Associative array of icons.
	 */
	public function getIcons(): array {
		return [];
	}
	/**
	 * Gets the banners for the theme.
	 *
	 * @return array<string,string> Associative array of banners.
	 */
	public function getBanners(): array {
		return [];
	}
	/**
	 * Gets the banners for the theme in RTL languages.
	 *
	 * @return array<string,string> Associative array of RTL banners.
	 */
	public function getBannersRTL(): array {
		return [];
	}
	/**
	 * Gets the list of plugins that this plugin requires.
	 *
	 * @return string[] Array of required plugin identifiers.
	 */
	public function getRequiresPlugins(): array {
		$rawValue = $this->getPackageMeta()['RequiresPlugins'] ?? null;
		return empty( $rawValue )
			? [] : array_map( 'trim', explode( ',', $rawValue ) );
	}
	/**
	 * Gets the sections of the plugin description.
	 *
	 * @return array<string,string> Associative array of section names and their content.
	 */
	public function getSections(): array {
		return [];
	}
	/**
	 * Determines if this plugin is a network-only plugin.
	 *
	 * @return boolean True if this is a network plugin, false otherwise.
	 */
	public function getNetwork(): bool {
		return (bool) ( $this->getPackageMeta()['Network'] ?? false );
	}
	/**
	 * Gets the plugin package metadata.
	 *
	 * Parses plugin file headers to extract metadata using a SelectHeadersPackageMetaParser.
	 * Result is cached for subsequent calls.
	 *
	 * @return array<string,string> Associative array of plugin metadata.
	 * @throws UnexpectedValueException If the metadata is invalid.
	 */
	protected function getPackageMeta(): array {
		return $this->packageMeta;
	}
	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	public function jsonSerialize(): mixed {
		return [
			'name'                     => $this->getName(),
			'fullSlug'                 => $this->getFullSlug(),
			'shortSlug'                => $this->getShortSlug(),
			'viewUrl'                  => $this->getViewUrl(),
			'version'                  => $this->getVersion(),
			'downloadUrl'              => $this->getDownloadUrl(),
			'tested'                   => $this->getTested(),
			'stable'                   => $this->getStable(),
			'tags'                     => $this->getTags(),
			'author'                   => $this->getAuthor(),
			'authorUrl'                => $this->getAuthorUrl(),
			'license'                  => $this->getLicense(),
			'licenseUrl'               => $this->getLicenseUrl(),
			'description'              => $this->getDescription(),
			'shortDescription'         => $this->getShortDescription(),
			'requiresWordPressVersion' => $this->getRequiresWordPressVersion(),
			'requiresPHPVersion'       => $this->getRequiresPHPVersion(),
			'textDomain'               => $this->getTextDomain(),
			'domainPath'               => $this->getDomainPath(),
			'icons'                    => $this->getIcons(),
			'banners'                  => $this->getBanners(),
			'bannersRtl'               => $this->getBannersRTL(),
			'requiresPlugins'          => $this->getRequiresPlugins(),
			'sections'                 => $this->getSections(),
			'network'                  => $this->getNetwork(),
		];
	}
}
