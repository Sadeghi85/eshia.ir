<?php namespace Sadeghi85\Docx2Html;

/**
 * Define a custom exception class
 */
class Docx2HtmlException extends \Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null)
	{
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString()
	{
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }


}