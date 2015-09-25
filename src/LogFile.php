<?php
namespace Gumbercules\IisLogParser;
use Gumbercules\IisLogParser\Exception\InvalidFileException;
use Gumbercules\IisLogParser\LogEntry;

/*
 * Represents a log file
 */

class LogFile
{

    /**
     * @var \SplFileObject
     */
    protected $file;

    /**
     * @var LogEntry[] Contains array of LogEntry objects
     */
    protected $entries;

    /*
     * LogFile constructor
     * @param \SplFileObject SplFileObject of file to be parsed
     */
    public function __construct(\SplFileObject $file)
    {
        if (!$file->isReadable()) {
            throw new InvalidFileException("File is not readable");
        }

        $this->setFile($file);

        $this->createEntries();
    }

    /**
     * @return \SplFileObject
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param \SplFileObject $file
     */
    public function setFile(\SplFileObject $file)
    {
        $this->file = $file;
    }

    /**
     * open log file, parse contents and create entries
     */
    protected function createEntries()
    {
        //read file
        $fileContents = $this->file->openFile("r");
        $fileContents = $fileContents->fread($this->file->getSize());

        if (empty($fileContents)) {
            throw new InvalidFileException("Log file is empty");
        }

        //break file up into lines
        $lines = preg_split('/$\R?^/m', $fileContents);

        foreach ($lines as $key => $line) {
            //remove commented lines with entry names
            if (substr($line, 0, 1) == "#") {
                unset($lines[$key]);
                continue;
            }

            $this->entries[] = new LogEntry($line);
        }
    }

    /*
     * @return LogEntry[]
     */
    public function getEntries()
    {
        return $this->entries;
    }
}