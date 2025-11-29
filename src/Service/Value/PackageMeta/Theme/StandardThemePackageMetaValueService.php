<?php
/**
 * Local Theme Package Meta Provider Service
 *
 * @package CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta
 * @since 1.0.0
 */

namespace CodeKaizen\WPPackageMetaProviderLocal\Service\Value\PackageMeta\Theme;

// phpcs:ignore Generic.Files.LineLength -- Keep import on one line.
use CodeKaizen\WPPackageMetaProviderContract\Contract\Value\PackageMeta\ThemePackageMetaValueContract;
// phpcs:ignore Generic.Files.LineLength -- Keep import on one line.
use CodeKaizen\WPPackageMetaProviderContract\Contract\Service\Value\PackageMeta\ThemePackageMetaValueServiceContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Assembler\String\MixedArrayStringAssemblerContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Reader\ReaderContract;
use CodeKaizen\WPPackageMetaProviderLocal\Contract\Value\SlugValueContract;
// phpcs:ignore Generic.Files.LineLength -- Keep import on one line.
use CodeKaizen\WPPackageMetaProviderLocal\Value\PackageMeta\ThemePackageMetaValue;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use UnexpectedValueException;
use Throwable;

/**
 * Service for creating local theme package meta providers.
 *
 * @since 1.0.0
 */
class StandardThemePackageMetaValueService implements ThemePackageMetaValueServiceContract {

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
	 * @var MixedArrayStringAssemblerContract
	 */
	protected MixedArrayStringAssemblerContract $assembler;

	/**
	 * Undocumented variable
	 *
	 * @var LoggerInterface
	 */
	protected LoggerInterface $logger;

	/**
	 * Constructor.
	 *
	 * @param ReaderContract                    $reader Reader.
	 * @param SlugValueContract                 $slugParser Slug data.
	 * @param MixedArrayStringAssemblerContract $assembler Assembler.
	 * @param LoggerInterface                   $logger Logger.
	 */
	public function __construct(
		ReaderContract $reader,
		SlugValueContract $slugParser,
		MixedArrayStringAssemblerContract $assembler,
		LoggerInterface $logger = new NullLogger()
	) {
		$this->reader     = $reader;
		$this->slugParser = $slugParser;
		$this->assembler  = $assembler;
		$this->logger     = $logger;
	}

	/**
	 * Creates a new ThemePackageMetaValue instance.
	 *
	 * @return ThemePackageMetaValueContract
	 * @throws UnexpectedValueException If the metadata is invalid.
	 * @throws Throwable Throws exception on other errors.
	 */
	public function getPackageMeta(): ThemePackageMetaValueContract {
		$content   = $this->reader->read();
		$assembled = $this->assembler->assemble( $content );
		return new ThemePackageMetaValue( $assembled, $this->slugParser, $this->logger );
	}
}
