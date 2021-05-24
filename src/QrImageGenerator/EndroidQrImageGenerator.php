<?php

namespace Dolondro\GoogleAuthenticator\QrImageGenerator;

use Dolondro\GoogleAuthenticator\Secret;
use Endroid\QrCode\QrCode;

class EndroidQrImageGenerator implements QrImageGeneratorInterface
{
    protected static $endroidWriterNames = ['binary', 'debug', 'eps', 'png', 'svg', 'fpdf'];
    protected $size;
    protected $writer;

    public function __construct($size = 200, $writer = 'png')
    {
        if (!is_numeric($size)) {
            throw new \InvalidArgumentException("Size is required to be numeric");
        }

        if (!in_array($writer, self::$endroidWriterNames)) {
            throw new \InvalidArgumentException($writer . "is not a valid Endroid writer.");
        }

        $this->size = $size;
        $this->writer = $writer;
    }

    public function generateUri(Secret $secret)
    {
        $qrCode = new QrCode($secret->getUri());
        $qrCode->setSize($this->size);

        $qrCode->setWriterByName($this->writer);

        return $qrCode->writeDataUri();
    }
}
