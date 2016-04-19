<?php

/**
 * This example shows how to use objects (instead of scalars) as nodes' data.
 * We create a tree that contains objects.
 * Then we traverse the tree and we serialise all nodes.
 */

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use dbeurive\Tree\Tree;
use dbeurive\Tree\Node;

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

$tree = new Tree(new MyDate()); // Root = date.
$tree->getRoot()
            ->addChild(new MyDate())->end() // Root + 1 day
            ->addChild(new MyDate())->end() // Root + 2 days
            ->addChild(new MyDate())        // Root + 3 days
                ->addChild(new MyDate())    // ...
                    ->addChild(new MyDate())
                        ->addChild(new MyDate())->end()
                        ->addChild(new MyDate())->end()
                    ->end()
                    ->addChild(new MyDate())->end()
                ->end()
                ->addChild(new MyDate())
                    ->addChild(new MyDate())
                        ->addChild(new MyDate())
                            ->addChild(new MyDate())
                                ->addChild(new MyDate())->end()
                                ->addChild(new MyDate())->end()
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
    /** @var MyDate $data */
    $data = $inNode->getData();
    $inOutResult[] = $data->serialise(); // Call the data' serializer.
};

$tree->traverse($traversalFunction, $result);

print_r($result);