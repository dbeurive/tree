<?php

/**
 * This example shows how to produce a "GRAPHVIZ" representation of a tree.
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
 * @var callable Function that convert a node's data into a printable string.
 * @param mixed $data The node's data.
 * @return string The function returns a string that represents the node's data.
 */
$optionalToString = function($data) {
    return $data;
};

$dot = $tree->toDot($optionalToString);
$fd = fopen(__DIR__ . DIRECTORY_SEPARATOR . "tree2dot.dot", "w");
fwrite($fd, $dot);
fclose($fd);
print "To create a graphical representation of the tree, install GRAPHVIZ and run the following command:\n";
print "dot -Tgif -Ograph tree2dot.dot\n";