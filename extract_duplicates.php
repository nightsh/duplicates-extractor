<?php namespace Nightsh\DuplicatesExtractor;

require_once( __DIR__ . '/vendor/autoload.php' );

use League\Csv\Reader;

use Aura\Cli\CliFactory;
$cli_factory = new CliFactory;
$context = $cli_factory->newContext($GLOBALS);

// // Try some line endings magic
// if (!ini_get("auto_detect_line_endings")) {
//     ini_set("auto_detect_line_endings", '1');
// }

// Get copies of superglobals
$env    = $context->env->get();
$server = $context->server->get();
$argv   = $context->argv->get();

// // equivalent to:
// // $value = isset($_ENV['key']) ? $_ENV['key'] : null;
// $value = $context->env->get('key');
//
// // equivalent to:
// // $value = isset($_ENV['key']) ? $_ENV['key'] : 'other_value';
// $value = $context->env->get('key', 'other_value');

$options = [
    'h',       // call for help
    'q',       // quiet switch
    'i:',      // (required) input file path
    'o::'      // (optional) output file path; output to STDOUT otherwise
];

$getopt = $context->getopt($options);

if ($getopt->get('-h')) {
    new Utils\Help();
    die();
}

if ($getopt->get('-i')) {
    if (file_exists($getopt->get('-i'))) {
        $input = $getopt->get('-i');
    } elseif (is_dir($getopt->get('-i'))) {
        die("You gave me a directory, WTF?!?!?!" . PHP_EOL);
    } else {
        die("Specified file does not exist!" . PHP_EOL);
    }
} else {
    die("No input file specified." . PHP_EOL);
}


if ($getopt->get('-o')) {
    if (file_exists($getopt->get('-i'))) {
        echo "File exists, it will be overwritten!" . PHP_EOL;
        define('U_STDOUT', false);
        $output = $getopt->get('-o');
    } else {
        echo "File does not exist, it will be created." . PHP_EOL;
        define('U_STDOUT', false);
        $output = $getopt->get('-o');
    }
} else {
    // die("You want output to STDOUT, but it's not implemented yet." . PHP_EOL);
    define('U_STDOUT', true);
}

/**********[ Real business from now on ]**********/

// Be aware there's currently no type checking. Use on your own risk!
$parser = new Parser\CSV($input);

