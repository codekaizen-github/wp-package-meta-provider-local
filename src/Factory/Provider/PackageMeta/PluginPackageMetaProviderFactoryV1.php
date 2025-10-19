<?php
/**
 * Local Plugin Package Meta Provider Factory
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Factory\Provider\PackageMeta
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Factory\Provider\PackageMeta;

// phpcs:ignore Generic.Files.LineLength.TooLong
use CodeKaizen\WPPackageMetaProviderContract\Contract\Factory\Provider\PackageMeta\PluginPackageMetaProviderFactoryContract;

use CodeKaizen\WPPackageMetaProviderContract\Contract\Provider\PackageMeta\PluginPackageMetaProviderContract;
use CodeKaizen\WPPackageMetaProviderLocal\Accessor\FileContentAccessor;
use CodeKaizen\WPPackageMetaProviderLocal\Accessor\SelectHeadersAccessor;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\SlugParserContract;
use CodeKaizen\WPPackageMetaProviderLocal\Provider\PackageMeta\PluginPackageMetaProvider;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Factory for creating local plugin package meta providers.
 *
 * @since 1.0.0
 */
class PluginPackageMetaProviderFactoryV1 implements PluginPackageMetaProviderFactoryContract {
	/**
	 * Filepath.
	 *
	 * @var string
	 */
	protected string $filePath;


	/**
	 * Undocumented variable
	 *
	 * @var LoggerInterface
	 */
	protected LoggerInterface $logger;

	/**
	 * Undocumented variable
	 *
	 * @var SlugParserContract
	 */
	protected SlugParserContract $slugParser;

	/**
	 * Constructor.
	 *
	 * @param string             $filePath Filepath.
	 * @param SlugParserContract $slugParser Slug Parser.
	 * @param LoggerInterface    $logger Logger.
	 */
	public function __construct(
		string $filePath,
		SlugParserContract $slugParser,
		LoggerInterface $logger = new NullLogger()
	) {
		$this->filePath   = $filePath;
		$this->slugParser = $slugParser;
		$this->logger     = $logger;
	}

	/**
	 * Creates a new PluginPackageMetaProvider instance.
	 *
	 * @return PluginPackageMetaProviderContract
	 */
	public function create(): PluginPackageMetaProviderContract {
		$reader = new FileContentAccessor( $this->filePath );
		$parser = new SelectHeadersAccessor(
			$reader,
			[
				'Name'            => 'Plugin Name',
				'PluginURI'       => 'Plugin URI',
				'Version'         => 'Version',
				'Description'     => 'Description',
				'Author'          => 'Author',
				'AuthorURI'       => 'Author URI',
				'TextDomain'      => 'Text Domain',
				'DomainPath'      => 'Domain Path',
				'Network'         => 'Network',
				'RequiresWP'      => 'Requires at least',
				'RequiresPHP'     => 'Requires PHP',
				'UpdateURI'       => 'Update URI',
				'RequiresPlugins' => 'Requires Plugins',
				// Site Wide Only is deprecated in favor of Network.
				// '_sitewide'       => 'Site Wide Only', // deprecated.
			]
		);
		return new PluginPackageMetaProvider( $this->slugParser, $parser );
	}
}
