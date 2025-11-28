<?php
/**
 * Factory for ThemePackageMetaValueService instances.
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Factory\Service\Value\PackageMeta
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Factory\Service\Value\PackageMeta;

use CodeKaizen\WPPackageMetaProviderContract\Contract\Service\Value\PackageMeta\ThemePackageMetaValueServiceContract;
use CodeKaizen\WPPackageMetaProviderLocal\Assembler\String\MixedArray\PackageMetaMixedArrayStringAssembler;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
use CodeKaizen\WPPackageMetaProviderLocal\Parser\HeadersParser;
use CodeKaizen\WPPackageMetaProviderLocal\Reader\FileReader;
use CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta\ThemePackageMetaValueService;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Undocumented class
 */
class ThemePackageMetaValueServiceFactoryV1 {
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
	 * Creates a new ThemePackageMetaValueService instance.
	 *
	 * @return ThemePackageMetaValueServiceContract
	 */
	public function create(): ThemePackageMetaValueServiceContract {
		$assembler = new PackageMetaMixedArrayStringAssembler(
			new HeadersParser(
				[
					'Name'        => 'Theme Name',
					'ThemeURI'    => 'Theme URI',
					'Description' => 'Description',
					'Author'      => 'Author',
					'AuthorURI'   => 'Author URI',
					'Version'     => 'Version',
					'Template'    => 'Template',
					'Status'      => 'Status',
					'Tags'        => 'Tags',
					'TextDomain'  => 'Text Domain',
					'DomainPath'  => 'Domain Path',
					'RequiresWP'  => 'Requires at least',
					'RequiresPHP' => 'Requires PHP',
					'UpdateURI'   => 'Update URI',
				]
			),
			$this->logger
		);
		$reader    = new FileReader( $this->filePath );
		return new ThemePackageMetaValueService(
			$reader,
			$this->slugParser,
			$assembler,
			$this->logger
		);
	}
}
