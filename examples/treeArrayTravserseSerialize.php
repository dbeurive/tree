<?php

/**
 * This example shows how to use objects (instead of scalars) as nodes' data. We create a tree that contains objects.
 * Then we traverse the tree and we serialise all nodes. Please note that the tree is represented by an array of imbricated arrays.
 */

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use dbeurive\Tree\Tree;


/**
 * Class MyDate
 * This class will be used to create instances of nodes' data.
 * Please note that it contains a method "serialise()".
 */

class MyDate {

    private $__creationDate = null;
    private static $__inter = 0;

    public function __construct() {
        $this->__creationDate = new DateTime();
        $this->__creationDate->add(new DateInterval('P' . self::$__inter . 'D'));
        self::$__inter += 1;
    }

    public function serialise($inOptFormat='Y-m-d H:i:s') {
        return $this->__creationDate->format($inOptFormat);
    }
}

$array = array (
    'data' => new MyDate(),
    'children' => array (
        array (
            'data' => new MyDate(),
            'children' => array ()
        ),

        array (
            'data' => new MyDate(),
            'children' => array ()
        ),

        array (
            'data' => new MyDate(),
            'children' => array (
                array (
                    'data' => new MyDate(),
                    'children' => array (
                        array (
                            'data' => new MyDate(),
                            'children' => array (
                                array (
                                    'data' => new MyDate(),
                                    'children' => array ()
                                ),
                                array (
                                    'data' => new MyDate(),
                                    'children' => array ()
                                )
                            )
                        ),
                        array (
                            'data' => new MyDate(),
                            'children' => array ()
                        )
                    )
                ),
                array (
                    'data' => new MyDate(),
                    'children' => array (
                        array (
                            'data' => new MyDate(),
                            'children' => array (
                                array (
                                    'data' => new MyDate(),
                                    'children' => array (
                                        array (
                                            'data' => new MyDate(),
                                            'children' => array (
                                                array (
                                                    'data' => new MyDate(),
                                                    'children' => array ()
                                                ),
                                                array (
                                                    'data' => new MyDate(),
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
    /** @var MyDate $data */
    $data = $inCurrent['data'];
    $inOutResult[] = $data->serialise(); // Call the data' serializer.

};

Tree::arrayTraverse($array, $traversalFunction, $result);

echo print_r($result, true);

