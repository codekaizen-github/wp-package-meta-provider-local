<?php
/**
 * Local Theme Package Meta Provider Factory
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Factory\Provider\PackageMeta
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Factory\Provider\PackageMeta;

use CodeKaizen\WPPackageMetaProviderContract\Contract\ThemePackageMetaContract;
use CodeKaizen\WPPackageMetaProviderContract\Contract\ThemePackageMetaProviderFactoryContract;
use CodeKaizen\WPPackageMetaProviderLocal\Accessor\FileContentAccessor;
use CodeKaizen\WPPackageMetaProviderLocal\Accessor\SelectHeadersAccessor;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Parser\SlugParserContract;
use CodeKaizen\WPPackageMetaProviderLocal\Provider\PackageMeta\ThemePackageMetaProvider;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Factory for creating local theme package meta providers.
 *
 * @since 1.0.0
 */
class ThemePackageMetaProviderFactoryV1 implements ThemePackageMetaProviderFactoryContract {
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
	 * Creates a new ThemePackageMetaProvider instance.
	 *
	 * @return ThemePackageMetaContract
	 */
	public function create(): ThemePackageMetaContract {
		$reader = new FileContentAccessor( $this->filePath );
		$parser = new SelectHeadersAccessor(
			$reader,
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
		);
		return new ThemePackageMetaProvider( $this->slugParser, $parser );
	}
}
