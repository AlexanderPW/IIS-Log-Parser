<?php

namespace Gumbercules\IisLogParser\Test;
use Gumbercules\IisLogParser\LogEntry;

class LogEntryTest extends \PHPUnit_Framework_TestCase
{

    /*
     * @var Gumbercules\IisLogParser\LogEntry
     */
    public $logEntry;

    public function setUp()
    {
        parent::setUp();

        $line = "2015-09-25 11:17:55 10.11.3.16 GET / - 80 - 10.11.161.24 Mozilla/5.0+(Windows+NT+6.1;+WOW64)+AppleWebKit/537.36+(KHTML,+like+Gecko)+Chrome/45.0.2454.99+Safari/537.36 401 2 5 202";

        $this->logEntry = new LogEntry($line);
    }

    public function testGetDateTime()
    {
        $this->assertInstanceOf("DateTimeImmutable", $this->logEntry->getDateTime());
        $this->assertEquals("2015-09-25 11:17:55", $this->logEntry->getDateTime()->format("Y-m-d H:i:s"));
    }

    public function testGetServerIp()
    {
        $this->assertEquals("10.11.3.16", $this->logEntry->getServerIp());
    }

    public function testGetRequestMethod()
    {
        $this->assertEquals("GET", $this->logEntry->getRequestMethod());
    }

    public function testGetRequestQuery()
    {
        $this->assertEmpty($this->logEntry->getRequestQuery());

        $this->logEntry->setRequestQuery("foo=1&bar=2");
        $this->assertEquals(
            ["foo" => 1, "bar" => 2],
            $this->logEntry->getRequestQuery()
        );
    }

    public function testGetServerPort()
    {
        $this->assertEquals("80", $this->logEntry->getServerPort());
    }

    public function testGetClientUsername()
    {
        $this->assertNull($this->logEntry->getClientUsername());

        $this->logEntry->setClientUsername("DOMAIN\\User");
        $this->assertEquals("DOMAIN\\User", $this->logEntry->getClientUsername());
    }

    public function testGetClientUserAgent()
    {
        $expected = "Mozilla/5.0+(Windows+NT+6.1;+WOW64)+AppleWebKit/537.36+(KHTML,+like+Gecko)+Chrome/45.0.2454.99+Safari/537.36";
        $this->assertEquals($expected, $this->logEntry->getClientUserAgent());
    }

    public function testGetResponseStatusCode()
    {
        $this->assertEquals(401, $this->logEntry->getResponseStatusCode());
    }

    public function testGetResponseSubStatusCode()
    {
        $this->assertEquals(2, $this->logEntry->getResponseSubStatusCode());
    }

    public function testGetResponseWin32StatusCode()
    {
        $this->assertEquals(5, $this->logEntry->getResponseWin32StatusCode());
    }

    public function testGetTimeTaken()
    {
        $this->assertEquals(202, $this->logEntry->getTimeTaken());
    }


}