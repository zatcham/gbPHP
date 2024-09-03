<?php
// preprocessor.php

class Preprocessor
{
    private $sourceCode;

    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new Exception("File not found: $filename");
        }
        $this->sourceCode = file_get_contents($filename);
    }

    public function preprocess()
    {
        // Replace £ with $
        $phpCode = str_replace('£', '$', $this->sourceCode);

        return $phpCode;
    }

    public function execute()
    {
        $phpCode = $this->preprocess();
        eval('?>' . $phpCode);
    }
}

// Cli execution
if ($argc < 2) {
    echo "Usage: php preprocessor.php <filename>\n";
    exit(1);
}

$filename = $argv[1];

try {
    $preprocessor = new Preprocessor($filename);
    $preprocessor->execute();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>

