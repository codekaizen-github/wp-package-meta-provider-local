<?php
/**
 * Factory for StandardPluginPackageMetaValueService instances.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Factory\Service\Value\PackageMeta\Plugin
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Factory\Service\Value\PackageMeta\Plugin;

// phpcs:ignore Generic.Files.LineLength.TooLong
use CodeKaizen\WPPackageMetaProviderContract\Contract\Factory\Service\Value\PackageMeta\PluginPackageMetaValueServiceFactoryContract;
use CodeKaizen\WPPackageMetaProviderContract\Contract\Service\Value\PackageMeta\PluginPackageMetaValueServiceContract;
use CodeKaizen\WPPackageMetaProviderLocal\Assembler\String\MixedArray\PackageMetaMixedArrayStringAssembler;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use CodeKaizen\WPPackageMetaProviderLocal\Parser\HeadersParser;
use CodeKaizen\WPPackageMetaProviderLocal\Reader\FileReader;
use CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta\Plugin\StandardPluginPackageMetaValueService;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Undocumented class
 */
class StandardPluginPackageMetaValueServiceFactory implements PluginPackageMetaValueServiceFactoryContract {
	/**
	 * URL to meta endpoint.
	 *
	 * @var string
	 */
	protected string $filePath;

	/**
	 * Key to extract metadata from.
	 *
	 * @var SlugValueContract
	 */
	protected SlugValueContract $slugParser;

	/**
	 * Undocumented variable
	 *
	 * @var LoggerInterface
	 */
	protected LoggerInterface $logger;

	/**
	 * Constructor.
	 *
	 * @param string            $filePath File with meta information.
	 * @param SlugValueContract $slugParser Slug data.
	 * @param LoggerInterface   $logger Logger.
	 */
	public function __construct(
		string $filePath,
		SlugValueContract $slugParser,
		LoggerInterface $logger = new NullLogger()
	) {
		$this->filePath   = $filePath;
		$this->slugParser = $slugParser;
		$this->logger     = $logger;
	}
	/**
	 * Creates a new StandardPluginPackageMetaValueService instance.
	 *
	 * @return PluginPackageMetaValueServiceContract
	 */
	public function create(): PluginPackageMetaValueServiceContract {
		$assembler = new PackageMetaMixedArrayStringAssembler(
			new HeadersParser(
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
			),
			$this->logger
		);
		$reader = new FileReader( $this->filePath );
		return new StandardPluginPackageMetaValueService(
			$reader,
			$this->slugParser,
			$assembler,
			$this->logger
		);
	}
}
