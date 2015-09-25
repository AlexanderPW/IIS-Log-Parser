# IIS Log Parser #

PHP class for parsing IIS log entries

# Installation #

Include in your project with composer:
```
composer require gumbercules/iislogparser
```

# Example usage #
```php
<?php
use Gumbercules\IisLogParser\LogFile;

//create an instance of \SplFileObject to inject into LogFile
$pathToFile = "c:\\some_file.log";
$file = new \SplFileObject($pathToFile);

//create instance of LogFile using \SplFileObject
$logFile = new LogFile($pathToFile);

//you will now have an array of LogEntry objects available via LogFile's getEntries() method
foreach ($logFile->getEntries() as $entry) {
    echo $entry->getRequestMethod();
    //GET
}
```

# Fields on an entry #

The following fields are available on a LogEntry object. Please note, I have done this based on (what I assume)
is the default IIS logging set-up. It may be possible to have additional fields. This library does not yet support this. 

* `\DateTimeImmutable` Date time - accessed by `getDateTime()`
* `string` Server IP - accessed by `getServerIp()`
* `string` Server port - accessed by `getServerPort()`
* `string` Request method - accessed by `getRequestMethod()`
* `string` Request URI stem - accessed by `getRequestUri()`
* `Array` Request query - query string key/value pairs stored in array, accessed by `getRequestQuery()`
* `string` Client IP - accessed by `getClientIp()`
* `string` Client username (as recognized by IIS with Windows Authentication enabled) - accessed by `getClientUsername()`
* `string` Client user agent - accessed by `getClientUserAgent()`
* `int` Response status code - accessed by `getResponseStatusCode()`
* `int` Response status sub-code - accessed by `getResponseStatusSubCode()`
* `int` Response WIN32 status code - accessed by `getResponseStatusWin32Code()` - see [list of error codes](https://msdn.microsoft.com/en-us/library/ms681381.aspx)
* `int` Time taken (in seconds) - accessed by `getTimeTaken()` 


