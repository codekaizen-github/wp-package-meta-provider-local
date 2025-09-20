<?php
/**
 * Local Plugin Package Meta Provider Factory
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Factory\Provider\PackageMeta;

use CodeKaizen\WPPackageMetaProviderContract\Contract\PluginPackageMetaContract;
use CodeKaizen\WPPackageMetaProviderContract\Contract\PluginPackageMetaProviderFactoryContract;
use CodeKaizen\WPPackageMetaProviderLocal\Parser\PackageMeta\SelectHeadersAccessor;
use CodeKaizen\WPPackageMetaProviderLocal\Reader\FileContentAccessor;
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
	 * Constructor.
	 *
	 * @param string          $filePath Filepath.
	 * @param LoggerInterface $logger Logger.
	 */
	public function __construct( string $filePath, LoggerInterface $logger = new NullLogger() ) {
		$this->filePath = $filePath;
		$this->logger   = $logger;
	}

	/**
	 * Creates a new PluginPackageMetaProvider instance.
	 *
	 * @return PluginPackageMetaContract
	 */
	public function create(): PluginPackageMetaContract {
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
		return new PluginPackageMetaProvider( $parser );
	}
}
