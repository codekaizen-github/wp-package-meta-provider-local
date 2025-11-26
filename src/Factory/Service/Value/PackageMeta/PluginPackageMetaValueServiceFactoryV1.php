<?php
/**
 * Factory for PluginPackageMetaValueService instances.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Factory\Service\Value\PackageMeta
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Factory\Service\Value\PackageMeta;

use CodeKaizen\WPPackageMetaProviderContract\Contract\Service\Value\PackageMeta\PluginPackageMetaValueServiceContract;
use CodeKaizen\WPPackageMetaProviderLocal\Assembler\Array\PackageMeta\StringPackageMetaArrayAssembler;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use CodeKaizen\WPPackageMetaProviderLocal\Parser\HeadersParser;
use CodeKaizen\WPPackageMetaProviderLocal\Reader\FileReader;
use CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta\PluginPackageMetaValueService;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Undocumented class
 */
class PluginPackageMetaValueServiceFactoryV1 {
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
	 * Creates a new PluginPackageMetaValueService instance.
	 *
	 * @return PluginPackageMetaValueServiceContract
	 */
	public function create(): PluginPackageMetaValueServiceContract {
		$assembler = new StringPackageMetaArrayAssembler(
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
		return new PluginPackageMetaValueService(
			$reader,
			$this->slugParser,
			$assembler,
			$this->logger
		);
	}
}
