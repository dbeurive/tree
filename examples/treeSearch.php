<?php

/**
 * This example shows how search for nodes with given values.
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
 * This function is used to compare two nodes' values.
 * @param string $inData1 First value to compare.
 * @param string $inData2 Second value to compare.
 * @return bool If the values are identical, then the function returns the value true. Otherwise, it returns the value true.
 */
$dataComparator = function($inData1, $inData2) {
    return $inData1 === $inData2;
};

// We should select 2 nodes.
$result = $tree->search("A", 0, $dataComparator);

/** @var \dbeurive\Tree\Node $_node */
foreach ($result as $_node) {
    print $_node->getData() . " -> Object(" . spl_object_hash($_node) . ")\n";
}

