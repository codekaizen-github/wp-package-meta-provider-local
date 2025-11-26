<?php
/**
 * Local Plugin Package Meta Provider Service
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta;

// phpcs:ignore Generic.Files.LineLength -- Keep import on one line.
use CodeKaizen\WPPackageMetaProviderContract\Contract\Value\PackageMeta\PluginPackageMetaValueContract;
// phpcs:ignore Generic.Files.LineLength -- Keep import on one line.
use CodeKaizen\WPPackageMetaProviderContract\Contract\Service\Value\PackageMeta\PluginPackageMetaValueServiceContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\Array\PackageMeta\StringPackageMetaArrayAssemblerContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Reader\ReaderContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
// phpcs:ignore Generic.Files.LineLength -- Keep import on one line.
use CodeKaizen\WPPackageMetaProviderLocal\Value\PackageMeta\PluginPackageMetaValue;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use UnexpectedValueException;
use Throwable;

/**
 * Service for creating local plugin package meta providers.
 *
 * @since 1.0.0
 */
class PluginPackageMetaValueService implements PluginPackageMetaValueServiceContract {

	/**
	 * Reader.
	 *
	 * @var ReaderContract
	 */
	protected ReaderContract $reader;

	/**
	 * Slug parser.
	 *
	 * @var SlugValueContract
	 */
	protected SlugValueContract $slugParser;

	/**
	 * Assembler.
	 *
	 * @var StringPackageMetaArrayAssemblerContract
	 */
	protected StringPackageMetaArrayAssemblerContract $assembler;

	/**
	 * Undocumented variable
	 *
	 * @var LoggerInterface
	 */
	protected LoggerInterface $logger;

	/**
	 * Constructor.
	 *
	 * @param ReaderContract                          $reader Reader.
	 * @param SlugValueContract                       $slugParser Slug data.
	 * @param StringPackageMetaArrayAssemblerContract $assembler Assembler.
	 * @param LoggerInterface                         $logger Logger.
	 */
	public function __construct(
		ReaderContract $reader,
		SlugValueContract $slugParser,
		StringPackageMetaArrayAssemblerContract $assembler,
		LoggerInterface $logger = new NullLogger()
	) {
		$this->reader     = $reader;
		$this->slugParser = $slugParser;
		$this->assembler  = $assembler;
		$this->logger     = $logger;
	}

	/**
	 * Creates a new PluginPackageMetaValue instance.
	 *
	 * @return PluginPackageMetaValueContract
	 * @throws UnexpectedValueException If the metadata is invalid.
	 * @throws Throwable Throws exception on other errors.
	 */
	public function getPackageMeta(): PluginPackageMetaValueContract {
		$content   = $this->reader->read();
		$assembled = $this->assembler->assemble( $content );
		return new PluginPackageMetaValue( $assembled, $this->slugParser, $this->logger );
	}
}
