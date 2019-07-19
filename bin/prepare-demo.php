#!/usr/bin/env php
<?php

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Debug\Debug;

//umask( 0000 );

set_time_limit(0);

// Ensure UTF-8 is used in string operations
setlocale(LC_CTYPE, 'C.UTF-8');

/** @var Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

$input = new ArgvInput();
$env = $input->getParameterOption(['--env', '-e'], getenv('SYMFONY_ENV') ?: 'dev');
$debug = getenv('SYMFONY_DEBUG') !== '0' && !$input->hasParameterOption(['--no-debug', '']) && $env !== 'prod';

if ($debug) {
    Debug::enable();
}

$kernel = new AppKernel($env, $debug);

$kernel->boot();

$container  = $kernel->getContainer();

$client = $container->get('solarium.client.econtent');

$update = $client->createUpdate();
$doc= $update->createDocument();

// Produkte/Home - content_type_name_id = product_group
$id = 'econtent1002830enggb';
$key = 'ses_product_group_ses_datamap_category_id_value_s';
$value = '2';

$doc->setKey('id', $id);
$doc->setField($key, $value);
$doc->setFieldModifier($key, 'set');

$update->addDocument($doc)->addCommit();

$key = 'ses_product_ses_datamap_ext_sum_of_basket_lines_value_i';

$products = [
        ['econtent9937884enggb', 100],
        ['econtent2806906enggb', 80],
        ['econtent22109688enggb', 60],
        ['econtent21595991enggb', 55],
        ['econtent21612939enggb', 54],
        ['econtent21794034enggb', 52],
];

foreach ($products as [$id, $value]) {
    $doc= $update->createDocument();
    $doc->setKey('id', $id);
    $doc->setField($key, $value);
    $doc->setFieldModifier($key, 'set');

    $update->addDocument($doc)->addCommit();
}

$result = $client->update($update);

echo 'ok';
