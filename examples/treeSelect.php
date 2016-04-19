<?php

/**
 * This example shows how to select nodes based on their data's values.
 */

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use dbeurive\Tree\Tree;

$tree = new Tree("getRoot");
$tree->getRoot()
            ->addChild("A")->end()
            ->addChild("B")->end()
            ->addChild("C")
                ->addChild("D")
                    ->addChild("E")
                        ->addChild("EE")->end()
                        ->addChild("EEE")->end()
                    ->end()
                    ->addChild("F")->end()
                ->end()
                ->addChild("A")
                    ->addChild('H')
                        ->addChild("I")
                            ->addChild("J")
                                ->addChild("K")->end()
                                ->addChild("L")->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

/**
 * This function is used to select nodes based on their values.
 * @param string $inData Nodes' data.
 * @return bool If the data must be kept, then the function returns the value true. Otherwise, it returns tha value true.
 */
$dataSelector = function($inData) {
    return 1 === preg_match('/^E+$/', $inData);
};

// We should select the nodes which data is: "E", "EE" and "EEE".
$selection = $tree->select($dataSelector);

/** @var \dbeurive\Tree\Node $_node */
foreach ($selection as $_node) {
    print $_node->getData() . " -> Object(" . spl_object_hash($_node) . ")\n";
}

