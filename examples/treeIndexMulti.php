<?php

/**
 * This example shows how to create an index that references all nodes within the tree.
 * Indexes are generated from the nodes' data.
 * Please note that, in this example, we assume that multiple nodes may have the same data value.
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
        if (self::$__inter > 3) self::$__inter = 0; else self::$__inter += 1;
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
 * @var callable This function generates an index from a given data.
 * @param MyDate $inData Data to serialize.
 * @return string The function returns the generated index.
 */
$indexBuilder = function(MyDate $inData) {
    return $inData->serialise(); // Call the data' serializer.
};

// Please note the use of the second parameter (which value is false).
// This tells the function that indexes should point to array of nodes.
$index = $tree->index($indexBuilder, false);

/** @var array $_value */
foreach ($index as $_key => $_value) {
    print "$_key => " . count($_value) . " elements.\n";
    foreach ($_value as $_o) {
        print "  -- Object(" . spl_object_hash($_o) . ")\n";
    }
}