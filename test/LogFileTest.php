<?php
namespace Gumbercules\IisLogParser\Test;
use Gumbercules\IisLogParser\LogFile;
use Gumbercules\IisLogParser\LogEntry;

class LogFileTest extends \PHPUnit_Framework_TestCase
{

    public $logFile;

    public function setUp()
    {
        parent::setUp();

        $path = getcwd()
                . DIRECTORY_SEPARATOR
                . "test"
                . DIRECTORY_SEPARATOR
                . "sample.log";

        $this->logFile = new LogFile(new \SplFileObject($path));
    }

    public function testSetFile()
    {
        $this->assertInstanceOf("SplFileObject", $this->logFile->getFile());

        $entries = $this->logFile->getEntries();

        $this->assertInstanceOf(LogEntry::class, $entries[0]);
        $this->assertEquals(2, count($entries));
    }

    public function testSort()
    {
        $entries = $this->logFile->getEntries("dateTime", "DESC");
        $this->assertNotFalse(stripos($entries[0]->getLine(), "LastnameX"));

    }
}