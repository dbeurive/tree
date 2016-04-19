<?php

/**
 * This example shows how to search for a node's data within the entire tree.
 */

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use dbeurive\Tree\Tree;
use dbeurive\Tree\Node;

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
 * @var callable Function used to compare two nodes' values.
 * @param mixed $value1 First value.
 * @param mixed $value2 Second value.
 * @return bool If $value1 is equal to $value2, then the function returns the value "true".
 *         Otherwise the function returns the value "false".
 */
$optionalCompareFunction = function($value1, $value2) {
    return $value1 == $value2;
};

/**
 * @var array List of nodes.
 */
$found = $tree->search("A", 0, $optionalCompareFunction);

/**
 * @var int $_index
 * @var Node $_node
 */
foreach ($found as $_index => $_node) {
    $label = $_node->isLeaf() ? "this is a leaf" : "this is not a leaf";
    echo spl_object_hash($_node) . " " . $_node->getData() . " ($label)\n";
}

