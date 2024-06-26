<?php

require('../vendor/autoload.php');

use Gorkau\DockerPhpGenerator\Classes\DockerGenerator;
use Gorkau\DockerPhpGenerator\Classes\Output;
use Gorkau\DockerPhpGenerator\Classes\PHPVersions\PHPVersionFactory;
use Gorkau\DockerPhpGenerator\Classes\UserInput;
use Gorkau\DockerPhpGenerator\Classes\UserInputReader;


$userInputReader = new UserInputReader();
$output = new Output();

$modules = [];

$phpVersion = (new UserInput($userInputReader, $output, "What PHP version do you want?", ["8.2"], true))->get();
//$isXDebug = (new UserInput($userInputReader, $output, "Do you want XDebug?", ["Y", "N"], true))->get();
$isGd = (new UserInput($userInputReader, $output, "Do you want gd?", ["Y", "N"], true))->get();
if ($isGd) {
    $modules[] = 'Gd';
}

$isMySQL = (new UserInput($userInputReader, $output, "Do you want MySQL?", ["Y", "N"], true))->get();
if ($isMySQL) {
    $modules[] = 'MySQL';
}

$php = new PHPVersionFactory($phpVersion, $modules);
//$wwwDataId = (new UserInput($userInputReader, $output, "ID for www-data (usually 33)?", [], true))->get();

$dockerGenerator = new DockerGenerator($php->get());
$dockerFile = $dockerGenerator->generate();

echo $dockerFile;