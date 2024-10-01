<?php

namespace Mpdf\Fonts;

class FontFileFinder
{

	private $directories;

	public function __construct($directories)
	{
		$this->setDirectories($directories);
	}

	public function setDirectories($directories)
	{
		if (!is_array($directories)) {
			$directories = [$directories];
		}

		$this->directories = $directories;
	}

	public function findFontFile($name, $download_if_missing = true)
	{
		foreach ($this->directories as $directory) {
			$filename = $directory . '/' . $name;
			if (file_exists($filename)) {
				return $filename;
			}
		}

		if ( $download_if_missing ) {
			// Download missing fonts.
			@file_put_contents( $filename, fopen( "https://www.pimwick.com/pw-gift-cards-fonts/$name", 'r' ) );

			return $this->findFontFile( $name, false );
		}

		throw new \Mpdf\MpdfException(sprintf('Cannot find TTF TrueType font file "%s" in configured font directories.', $name));
	}
}
