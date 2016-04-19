<?php

/**
 * This example illustrates the procedure to create a tree (an object of class \dbeurive\Tree\Tree from an array of imbricated arrays.
 */

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use dbeurive\Tree\Tree;

$array = array (
    'data' => 'getRoot',
    'children' => array (
        array (
            'data' => 'A',
            'children' => array ()
        ),

        array (
            'data' => 'B',
            'children' => array ()
        ),

        array (
            'data' => 'C',
            'children' => array (
                array (
                    'data' => 'D',
                    'children' => array (
                        array (
                            'data' => 'E',
                            'children' => array (
                                array (
                                    'data' => 'EE',
                                    'children' => array ()
                                ),
                                array (
                                    'data' => 'EEE',
                                    'children' => array ()
                                )
                            )
                        ),
                        array (
                            'data' => 'F',
                            'children' => array ()
                        )
                    )
                ),
                array (
                    'data' => 'A',
                    'children' => array (
                        array (
                            'data' => 'H',
                            'children' => array (
                                array (
                                    'data' => 'I',
                                    'children' => array (
                                        array (
                                            'data' => 'J',
                                            'children' => array (
                                                array (
                                                    'data' => 'K',
                                                    'children' => array ()
                                                ),
                                                array (
                                                    'data' => 'L',
                                                    'children' => array ()
                                                ),
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            )
        )
    )
);

$tree = Tree::fromArray($array);

// Generate the DOT representation, so we can verify that the tree is OK.
$dot = $tree->toDot();
$fd = fopen(__DIR__ . DIRECTORY_SEPARATOR . "array2tree.dot", "w");
fwrite($fd, $dot);
fclose($fd);
print "To create a graphical representation of the tree, install GRAPHVIZ and run the following command:\n";
print "dot -Tgif -Ograph array2tree.dot\n";

