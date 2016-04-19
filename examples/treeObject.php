<?php

/**
 * this example shows how to create a tree using the tree builder. It creates an instance of class \dbeurive\Tree\Tree.
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

// Generate the DOT representation, so we can verify that the tree is OK.
$dot = $tree->toDot();
$fd = fopen(__DIR__ . DIRECTORY_SEPARATOR . "treeBuilder.dot", "w");
fwrite($fd, $dot);
fclose($fd);
print "To create a graphical representation of the tree, install GRAPHVIZ and run the following command:\n";
print "dot -Tgif -Ograph treeBuilder.dot\n";