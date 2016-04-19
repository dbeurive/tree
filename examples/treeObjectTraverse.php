<?php

/**
 * this example shows how to traverse a tree that is an object of class \dbeurive\Tree\Tree.
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
 * @var array This array will be manipulated by the traversal function.
 *      The traversal function if free to use this array as it sees fit.
 */
$result = [];

/**
 * @var callable The traversal function.
 * @param Node $inNode The current node.
 * @param array $inOutResult Reference to the array used by the traversal function.
 *              The traversal function if free to use this array as it sees fit.
 */
$traversalFunction = function(Node $inNode, array &$inOutResult) {
    $inOutResult[] = $inNode->getData();
};

$tree->traverse($traversalFunction, $result);

echo print_r($result, true);

