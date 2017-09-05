<?php

namespace Gumbercules\IisLogParser;
use Gumbercules\IisLogParser\Exception\InvalidEntryException;

/*
 * Represents a log entry
 */
class LogEntry
{

    /*
     * @var string Contains raw data for log entry
     */
    protected $line;

    /*
     * @var \DateTimeImmutable Date and time of entry
     */
    protected $dateTime;

    /*
     * @var string Server IP address
     */
    protected $serverIp;

    /*
     * @var string Server port
     */
    protected $serverPort;

    /*
     * @var string Request method (e.g. GET, POST, etc)
     */
    protected $requestMethod;

    /*
     * @var string Request URI stem not including hostname e.g. "/index.html"
     */
    protected $requestUri;

    /*
     * @var array Request query string
     */
    protected $requestQuery;

    /*
     * @var string Client IP address
     */
    protected $clientIp;

    /*
     * @var string Client username
     */
    protected $clientUsername;

    /*
     * @var string Client user agent
     */
    protected $clientUserAgent;

    /*
     * @var int Response status code
     */
    protected $responseStatusCode;

    /*
     * @var int Response sub-status code
     */
    protected $responseSubStatusCode;

    /*
     * @var int Response windows status code
     */
    protected $responseWin32StatusCode;

    /*
     * @var int Time taken in seconds
     */
    protected $timeTaken;

    /*
     * @const int Expected number of fields to be found in an IIS log entry
     */
    const EXPECTED_NUMBER_OF_FIELDS = 14;

    const FIELDS_FALLBACK = 15;

    /**
     * LogEntry constructor.
     * @param $line
     */
    public function __construct($line)
    {
        $this->line = $line;

        $this->parse();
    }

    /*
     * Parse line into fields
     * @return void
     */
    protected function parse()
    {
        $fields = explode(" ", $this->line);

        array_filter($fields);

        $colCount = count($fields);

        if ($colCount == self::EXPECTED_NUMBER_OF_FIELDS) {
            $this->setDateTime($fields[0] . " " . $fields[1]);
            $this->setServerIp($fields[2]);
            $this->setRequestMethod($fields[3]);
            $this->setRequestUri($fields[4]);
            $this->setRequestQuery($fields[5]);
            $this->setServerPort($fields[6]);
            $this->setClientUsername($fields[7]);
            $this->setClientIp($fields[8]);
            $this->setClientUserAgent($fields[9]);
            $this->setResponseStatusCode($fields[10]);
            $this->setResponseSubStatusCode($fields[11]);
            $this->setResponseWin32StatusCode($fields[12]);
            $this->setTimeTaken($fields[13]);
        }
        elseif ($colCount == self::FIELDS_FALLBACK) {
            $this->setDateTime($fields[0] . " " . $fields[1]);
            $this->setServerIp($fields[2]);
            $this->setRequestMethod($fields[3]);
            $this->setRequestUri($fields[4]);
            $this->setRequestQuery($fields[5]);
            $this->setServerPort($fields[6]);
            $this->setClientUsername($fields[7]);
            $this->setClientIp($fields[8]);
            $this->setClientUserAgent($fields[9]);
            // field 10 not used
            $this->setResponseStatusCode($fields[11]);
            $this->setResponseSubStatusCode($fields[12]);
            $this->setResponseWin32StatusCode($fields[13]);
            $this->setTimeTaken($fields[14]);
        } else {
            $msg = "Expected " . self::EXPECTED_NUMBER_OF_FIELDS . " fields, found " . count($fields);
            throw new InvalidEntryException($msg);
        }
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return string
     */
    public function getServerIp()
    {
        return $this->serverIp;
    }

    /**
     * @return string
     */
    public function getServerPort()
    {
        return $this->serverPort;
    }

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * @return array
     */
    public function getRequestQuery()
    {
        return $this->requestQuery;
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }

    /**
     * @return string
     */
    public function getClientUsername()
    {
        return $this->clientUsername;
    }

    /**
     * @return string
     */
    public function getClientUserAgent()
    {
        return $this->clientUserAgent;
    }

    /**
     * @return int
     */
    public function getResponseStatusCode()
    {
        return $this->responseStatusCode;
    }

    /**
     * @return int
     */
    public function getResponseSubStatusCode()
    {
        return $this->responseSubStatusCode;
    }

    /**
     * @return int
     */
    public function getResponseWin32StatusCode()
    {
        return $this->responseWin32StatusCode;
    }

    /**
     * @return int
     */
    public function getTimeTaken()
    {
        return $this->timeTaken;
    }

    /**
     * @param string $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }

    /**
     * @param string $dateTime
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @param string $serverIp
     */
    public function setServerIp($serverIp)
    {
        $this->serverIp = $serverIp;
    }

    /**
     * @param string $serverPort
     */
    public function setServerPort($serverPort)
    {
        $this->serverPort = $serverPort;
    }

    /**
     * @param string $requestMethod
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @param string $requestUri
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = $requestUri;
    }

    /**
     * @param string $requestQuery
     */
    public function setRequestQuery($requestQuery)
    {
        $this->requestQuery = $requestQuery;
    }

    /**
     * @param string $clientIp
     */
    public function setClientIp($clientIp)
    {
        $this->clientIp = $clientIp;
    }

    /**
     * @param string $clientUsername
     */
    public function setClientUsername($clientUsername)
    {
        $this->clientUsername = $clientUsername;
    }

    /**
     * @param string $clientUserAgent
     */
    public function setClientUserAgent($clientUserAgent)
    {
        $this->clientUserAgent = $clientUserAgent;
    }

    /**
     * @param string $responseStatusCode
     */
    public function setResponseStatusCode($responseStatusCode)
    {
        $this->responseStatusCode = $responseStatusCode;
    }

    /**
     * @param string $responseSubStatusCode
     */
    public function setResponseSubStatusCode($responseSubStatusCode)
    {
        $this->responseSubStatusCode = $responseSubStatusCode;
    }

    /**
     * @param string $responseWin32StatusCode
     */
    public function setResponseWin32StatusCode($responseWin32StatusCode)
    {
        $this->responseWin32StatusCode = $responseWin32StatusCode;
    }

    /**
     * @param int $timeTaken
     */
    public function setTimeTaken($timeTaken)
    {
        $this->timeTaken = $timeTaken;
    }

}