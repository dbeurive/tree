<?php

/**
 * this example shows how to traverse a tree represented by an array of imbricated arrays.
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

/**
 * @var array This array will be manipulated by the traversal function.
 *      The traversal function if free to use this array as it sees fit.
 */
$result = [];

/**
 * @var callable The traversal function.
 * @param array $inCurrent Current node.
 * @param bool $isLead This boolean tells the function whether the current node is a leaf or not.
 * @param (array|null $inParent Associative array that represents the parent's node.
 *        This value may be null is the current node is the getRoot node.
 * @param array $inOutResult Permanent variable used by the function to organize and store values.
 */
$traversalFunction = function(array $inCurrent, $isLead, $inParent, &$inOutResult) {
    $inOutResult[] = $inCurrent['data'];
};

Tree::arrayTraverse($array, $traversalFunction, $result);

echo print_r($result, true);