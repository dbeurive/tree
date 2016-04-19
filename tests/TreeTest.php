<?php

use dbeurive\Tree\Tree;
use dbeurive\Tree\Node;

class TreeTest extends PHPUnit_Framework_TestCase
{
    const VERBOSE = true;

    /** @var array $__nodesData This array contains the nodes' data. */
    private $__nodesData = [];
    /** @var array $__nodesObjects This array contains the nodes' objects. */
    private $__nodesObjects = [];
    /** @var null|int Number of nodes within the trees. */
    private $__numberOfNodes = null;
    /** @var Tree $__treeByData Tree created using the tree builder, injecting data. */
    private $__treeByData;
    /** @var Tree $__treeByObjects Tree created using the tree builder, injecting nodes. */
    private $__treeByObjects;
    /** @var array $__treeAsArray Tree represented by an array. */
    private $__treeAsArray;
    /** @var null|string Path the the fixtures' files. */
    private $__fixturesDir = null;


    /**
     * Function used to serialize data.
     * @param string $inData Data to serialize.
     * @return string
     * @note This function is related to the fixture "treeSerializedAsJson.json".
     */
    static private function __dataSerializer($inData) {
        return "2${inData}";
    }

    /**
     * Function used to deserialize data.
     * @param string $inData Serialized data.
     * @return string
     * @note This function is related to the fixtures "treeSerializedAsJson.json" and "treeAsJson.json".
     */
    static private function __dataDeserializer($inData) {
        return preg_replace('/^2(.+)$/', '$1', $inData);
    }

    /**
     * Initialize the list of available data and nodes.
     */
    private function __initContainers() {
        $this->__nodesData = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'A'];
        $this->__nodesObjects = array_map(function($v) { return new Node($v); }, $this->__nodesData);
        $this->__numberOfNodes = count($this->__nodesData);
        $this->__fixturesDir = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures';
    }

    /**
     * Return the next available data.
     * @param bool $inOptRewind If true, then set the current data index to the first available data.
     * @return string
     */
    private function __getData($inOptRewind=false) {
        static $index = 0;
        if ($inOptRewind) {
            $index = 0;
        }
        $data = $this->__nodesData[$index];
        $index += 1;
        return $data;
    }

    /**
     * Return the next available node.
     * @param bool $inOptRewind If true, then set the current data index to the first available node.
     * @return Node
     */
    private function __getNode($inOptRewind=false) {
        static $index = 0;
        if ($inOptRewind) {
            $index = 0;
        }
        /** @var Node $node */
        $node = $this->__nodesObjects[$index];
        $index += 1;
        return $node;
    }

    /**
     * Set up the test.
     */
    protected function setUp() {

        $this->__initContainers();

        // -------------------------------------------------------------------------------------------------------------
        // Create a tree using the tree builder - set data.
        // -------------------------------------------------------------------------------------------------------------

        $this->__treeByData = new Tree($this->__getData(true));
        $this->__treeByData->getRoot()
                ->addChild($this->__getData())->end()
                ->addChild($this->__getData())->end()
                ->addChild($this->__getData())
                    ->addChild($this->__getData())
                        ->addChild($this->__getData())
                            ->addChild($this->__getData())->end()
                            ->addChild($this->__getData())->end()
                        ->end()
                        ->addChild($this->__getData())->end()
                    ->end()
                ->addChild($this->__getData())
                    ->addChild($this->__getData())
                        ->addChild($this->__getData())
                            ->addChild($this->__getData())
                                ->addChild($this->__getData())->end()
                                ->addChild($this->__getData())->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        // -------------------------------------------------------------------------------------------------------------
        // Create a tree using the tree builder - set nodes.
        // -------------------------------------------------------------------------------------------------------------

        $this->__treeByObjects = new Tree($this->__getNode(true));
        $this->__treeByObjects->getRoot()
                ->addChild($this->__getNode())->end()
                ->addChild($this->__getNode())->end()
                ->addChild($this->__getNode())
                    ->addChild($this->__getNode())
                        ->addChild($this->__getNode())
                            ->addChild($this->__getNode())->end()
                            ->addChild($this->__getNode())->end()
                        ->end()
                        ->addChild($this->__getNode())->end()
                    ->end()
                ->addChild($this->__getNode())
                    ->addChild($this->__getNode())
                        ->addChild($this->__getNode())
                            ->addChild($this->__getNode())
                                ->addChild($this->__getNode())->end()
                                ->addChild($this->__getNode())->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        // -------------------------------------------------------------------------------------------------------------
        // Create the same tree by defining an array.
        // -------------------------------------------------------------------------------------------------------------

        $this->__treeAsArray =  array (
            'data' => $this->__getData(true),
            'children' => array (
                array (
                    'data' => $this->__getData(),
                    'children' => array ()
                ),

                array (
                    'data' => $this->__getData(),
                    'children' => array ()
                ),

                array (
                    'data' => $this->__getData(),
                    'children' => array (
                        array (
                            'data' => $this->__getData(),
                            'children' => array (
                                array (
                                    'data' => $this->__getData(),
                                    'children' => array (
                                        array (
                                            'data' => $this->__getData(),
                                            'children' => array ()
                                        ),
                                        array (
                                            'data' => $this->__getData(),
                                            'children' => array ()
                                        )
                                    )
                                ),
                                array (
                                    'data' => $this->__getData(),
                                    'children' => array ()
                                )
                            )
                        ),
                        array (
                            'data' => $this->__getData(),
                            'children' => array (
                                array (
                                    'data' => $this->__getData(),
                                    'children' => array (
                                        array (
                                            'data' => $this->__getData(),
                                            'children' => array (
                                                array (
                                                    'data' => $this->__getData(),
                                                    'children' => array (
                                                        array (
                                                            'data' => $this->__getData(),
                                                            'children' => array ()
                                                        ),
                                                        array (
                                                            'data' => $this->__getData(),
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
    }

    /**
     * Traverse a tree, using the tree that has been created by data injections.
     * Nodes have been instantiated during the tree's creation.
     */
    public function testTraverseData() {
        $result = [];
        $userProvidedFunction = function(Node $inNode, array &$inOutResult) {
            $inOutResult[] = $inNode->getData();
        };
        $this->__treeByData->traverse($userProvidedFunction, $result);

        $occurrences = array_count_values($result);
        $this->assertcount(15, $result);

        // "A" should be found 2 times.
        $this->assertEquals(2, $occurrences['A']);

        // All other values should be found only once.
        foreach (['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'] as $_data) {
            $this->assertEquals(1, $occurrences[$_data]);
        }
    }

    /**
     * Traverse the tree, using the tree that has been created by nodes injections.
     * Nodes have been instantiated prior to the tree's creation.
     */
    public function testTraverseObjects() {
        $result = [];
        $userProvidedFunction = function(Node $inNode, array &$inOutResult) {
            $inOutResult[] = spl_object_hash($inNode); // We store the objects' identifiers.
        };
        $this->__treeByObjects->traverse($userProvidedFunction, $result);

        $occurrences = array_count_values($result);
        $this->assertCount(15, $result);

        // "A" should be found 2 times.
        $entry1 = spl_object_hash($this->__nodesObjects[0]);  // This is the first "A".
        $entry2 = spl_object_hash($this->__nodesObjects[14]); // This is the second "A".
        $this->assertContains($entry1, $result);
        $this->assertContains($entry2, $result);

        // All other values should be found only once.
        foreach (['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'] as $_index => $_data) {
            $entry = spl_object_hash($this->__nodesObjects[$_index + 1]);
            $this->assertContains($entry, $result);
            $this->assertEquals(1, $occurrences[$entry]);
        }
    }

    /**
     * Make sure that the method used to generate a GRAPHVIW representation if the tree works as expected.
     */
    public function testToDot() {
        $path = __DIR__ . DIRECTORY_SEPARATOR . "testToDot.dot";
        $dot = $this->__treeByData->toDot();
        $fd = fopen($path, "w");
        fwrite($fd, $dot);
        fclose($fd);
        $this->assertFileExists($path);
    }

    /**
     * This method checks that the method used to convert a tree to an array works as expected.
     */
    public function testToArray() {
        $fixture = $this->__fixturesDir . DIRECTORY_SEPARATOR . 'treeAsJson.json';
        $this->assertJsonStringEqualsJsonFile($fixture, json_encode($this->__treeByData->toArray()));
        $this->assertJsonStringEqualsJsonFile($fixture, json_encode($this->__treeByObjects->toArray()));
        $this->assertJsonStringEqualsJsonFile($fixture, json_encode(Tree::fromArray($this->__treeAsArray)->toArray()));

        $serializer = function($v) {
            return self::__dataSerializer($v);
        };

        $fixture = $this->__fixturesDir . DIRECTORY_SEPARATOR . 'treeSerializedAsJson.json';
        $this->assertJsonStringEqualsJsonFile($fixture, json_encode($this->__treeByData->toArray($serializer)));
        $this->assertJsonStringEqualsJsonFile($fixture, json_encode($this->__treeByObjects->toArray($serializer)));
        $this->assertJsonStringEqualsJsonFile($fixture, json_encode(Tree::fromArray($this->__treeAsArray)->toArray($serializer)));
    }

    /**
     * This method checks that the method used to create a tree from an array representation works as expected.
     */
    public function testFromArray() {
        $fixture = $this->__fixturesDir . DIRECTORY_SEPARATOR . 'treeAsJson.json';
        $treeFromArray = Tree::fromArray($this->__treeAsArray);
        $this->assertJsonStringEqualsJsonFile($fixture, json_encode($treeFromArray->toArray()));

        $deserializer = function($v) {
            return self::__dataDeserializer($v);
        };

        $source = $this->__fixturesDir . DIRECTORY_SEPARATOR . 'treeSerializedAsJson.json';
        $array = json_decode(file_get_contents($source), true);
        $treeFromArray = Tree::fromArray($array, $deserializer);
        $this->assertJsonStringEqualsJsonFile($fixture, json_encode($treeFromArray->toArray()));
    }

    /**
     * This method checks that the method used to traverse a tree defined as an array works as expected.
     */
    public function testArrayTraverse() {
        $fixture = $this->__fixturesDir . DIRECTORY_SEPARATOR . 'traverse.json';
        $result = [];
        $function = function(array $inCurrent, $isLead, $inParent, &$inOutResult) {
            $inOutResult[] = $inCurrent['data'];
        };
        Tree::arrayTraverse($this->__treeAsArray, $function, $result);
        $this->assertJsonStringEqualsJsonFile($fixture, json_encode($result));
    }

    /**
     * Search nodes by values, using the tree that has been created by data injections.
     * Nodes have been instantiated during the tree's creation.
     * The search may return more than one match.
     */
    public function testSearchDataMulti() {

        /**
         * @var Node $found[0]
         * @var Node $found[1]
         * @var array $found
         */

        // --- Test 1

        $found = $this->__treeByData->search('A');
        $this->assertCount(2, $found);
        $this->assertNotSame($found[0], $found[1]);
        $this->assertEquals($found[0]->getData(), 'A');
        $this->assertEquals($found[1]->getData(), 'A');

        // --- Test 2

        $found = $this->__treeByData->search('B');
        $this->assertCount(1, $found);
        $this->assertEquals($found[0]->getData(), 'B');

        // --- Test 3

        $found = $this->__treeByData->search('Z');
        $this->assertEmpty($found);
    }

    /**
     * Search nodes by values, using the tree that has been created by data injections.
     * Nodes have been instantiated during the tree's creation.
     * The search only return one match.
     */
    public function testSearchDataUnique() {

        /**
         * @var Node $found[0]
         * @var array $found
         */

        // --- Test 1

        $found = $this->__treeByData->search('A', 1);
        $this->assertCount(1, $found);
        $this->assertEquals($found[0]->getData(), 'A');

        // --- Test 2

        $found = $this->__treeByData->search('B', 1);
        $this->assertCount(1, $found);
        $this->assertEquals($found[0]->getData(), 'B');
    }

    /**
     * Search nodes by values, using the tree that has been created by data injections.
     * Nodes have been instantiated during the tree's creation.
     * The search may return more than one match.
     * The matches are detected using a user provider comparator.
     */
    public function testCustomSearchData() {

        /**
         * @var Node $found[0]
         * @var array $found
         */

        $numberOfMatches = 0;
        $userProvidedComparator = function ($d1, $d2) use (&$numberOfMatches) {
            if ($d1 !== $d2) return false;
            $numberOfMatches += 1;
            return $numberOfMatches > 1;
        };
        $found = $this->__treeByData->search('A', 0, $userProvidedComparator);
        $this->assertCount(1, $found);
        $this->assertEquals($found[0]->getData(), 'A');
    }

    /**
     * Search nodes by values, using the tree that has been created by nodes injections.
     * Nodes have been instantiated prior to the tree's creation.
     * The search may return more than one match.
     */
    public function testSearchNodesNulti() {

        /**
         * @var Node $found[0]
         * @var Node $found[1]
         * @var array $found
         */

        // --- Test 1

        $found = $this->__treeByObjects->search('A');
        $this->assertCount(2, $found);
        $this->assertSame($found[0], $this->__nodesObjects[0]);
        $this->assertSame($found[1], $this->__nodesObjects[14]);

        // --- Test 2

        $found = $this->__treeByObjects->search('B');
        $this->assertCount(1, $found);
        $this->assertSame($found[0], $this->__nodesObjects[1]);

        // --- Test 3

        $found = $this->__treeByObjects->search('Z');
        $this->assertEmpty($found);
    }

    /**
     * Search nodes by values, using the tree that has been created by nodes injections.
     * Nodes have been instantiated prior to the tree's creation.
     * The search returns only one match.
     */
    public function testSearchNodesUnique() {

        /**
         * @var Node $found[0]
         * @var array $found
         */

        // --- Test 1

        $found = $this->__treeByObjects->search('A', 1);
        $this->assertCount(1, $found);
        $this->assertSame($found[0], $this->__nodesObjects[0]);

        // --- Test 2

        $found = $this->__treeByObjects->search('B', 1);
        $this->assertCount(1, $found);
        $this->assertSame($found[0], $this->__nodesObjects[1]);
    }

    /**
     * Search nodes by values, using the tree that has been created by nodes injections.
     * Nodes have been instantiated prior to the tree's creation.
     * The search may return more than one match.
     * The matches are detected using a user provider comparator.
     */
    public function testCustomSearchNodes() {

        /**
         * @var Node $found[0]
         * @var array $found
         */

        $numberOfMatches = 0;
        $userProvidedComparator = function ($d1, $d2) use (&$numberOfMatches) {
            if ($d1 !== $d2) return false;
            $numberOfMatches += 1;
            return $numberOfMatches > 1;
        };
        $found = $this->__treeByObjects->search('A', 0, $userProvidedComparator);
        $this->assertCount(1, $found);
        $this->assertSame($found[0], $this->__nodesObjects[14]);
    }

    /**
     * Select nodes by values, using the tree that has been created by data injections.
     * Nodes have been instantiated during the tree's creation.
     */
    public function testCustomSelectData() {

        /**
         * @var Node $selected[0]
         * @var Node $selected[1]
         * @var Node $selected[2]
         * @var array $selected
         */

        // --- Test 1

        $selector = function($inData) {
            return preg_match('/^C|D|E$/', $inData);
        };

        $selected = $this->__treeByData->select($selector);
        $selectedData = array_map(function(Node $v) { return $v->getData(); }, $selected);
        $this->assertCount(3, $selected);
        $this->assertContains('C', $selectedData);
        $this->assertContains('D', $selectedData);
        $this->assertContains('E', $selectedData);

        // --- Test 2

        $selector = function($inData) {
            return preg_match('/^A|X|Y|Z$/', $inData);
        };

        $selected = $this->__treeByData->select($selector);
        $selectedData = array_map(function(Node $v) { return $v->getData(); }, $selected);
        $this->assertCount(2, $selected);
        $this->assertEquals(['A', 'A'], $selectedData);

        // --- Test 3

        $selector = function($inData) {
            return preg_match('/^X|Y|Z$/', $inData);
        };

        $selected = $this->__treeByData->select($selector);
        $this->assertEmpty($selected);
    }

    /**
     * Select nodes by values, using the tree that has been created by nodes injections.
     * Nodes have been instantiated prior to the tree's creation.
     */
    public function testSelectObjects() {

        /**
         * @var Node $selected[0]
         * @var Node $selected[1]
         * @var Node $selected[2]
         * @var array $selected
         */

        // --- Test 1

        $selector = function($inData) {
            return preg_match('/^C|D|E$/', $inData);
        };

        $selected = $this->__treeByObjects->select($selector);
        $ids = array_map(function(Node $v) {return spl_object_hash($v); }, $selected);
        $this->assertCount(3, $selected);
        $this->assertContains(spl_object_hash($this->__nodesObjects[2]), $ids);
        $this->assertContains(spl_object_hash($this->__nodesObjects[3]), $ids);
        $this->assertContains(spl_object_hash($this->__nodesObjects[4]), $ids);

        // --- Test 2

        $selector = function($inData) {
            return preg_match('/^A|X|Y|Z$/', $inData);
        };

        $selected = $this->__treeByObjects->select($selector);
        $ids = array_map(function(Node $v) {return spl_object_hash($v); }, $selected);
        $this->assertCount(2, $selected);
        $this->assertContains(spl_object_hash($this->__nodesObjects[0]), $ids);
        $this->assertContains(spl_object_hash($this->__nodesObjects[14]), $ids);
    }

    /**
     * Index a tree using the tree that has been created by data injections.
     * Nodes have been instantiated during the tree's creation.
     * Indexes points to arrays of nodes.
     */
    public function testIndexDataMulti() {

        $index = $this->__treeByData->index(null, false); // IDs are SHA1(data).
        $this->assertCount($this->__numberOfNodes - 1, $index);

        $this->assertCount(2, $index[sha1('A')]);
        $this->assertEquals('A', $index[sha1('A')][0]->getData());
        $this->assertEquals('A', $index[sha1('A')][1]->getData());

        foreach (['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'] as $_data) {
            $this->assertCount(1, $index[sha1($_data)]);
            $this->assertEquals($_data, $index[sha1($_data)][0]->getData());
        }
    }

    /**
     * Index a tree using the tree that has been created by data injections.
     * Nodes have been instantiated during the tree's creation.
     * Indexes points to (single) nodes.
     */
    public function testIndexDataUnique() {
        $index = $this->__treeByData->index(); // IDs are SHA1(data).

        foreach ($this->__nodesData as $_data) {
            /** @var Node $node */
            $node = $index[sha1($_data)];
            $this->assertEquals($_data, $node->getData());
        }
    }

    /**
     * Index a tree using the tree that has been created by objects injections.
     * Nodes have been instantiated prior to the tree's creation.
     * Indexes points to arrays of nodes.
     */
    public function testIndexObjectsMulti() {
        $index = $this->__treeByObjects->index(null, false); // IDs are SHA1(data).
        $this->assertCount($this->__numberOfNodes - 1, $index);

        $indexEntry = $index[sha1('A')];
        $this->assertCount(2, $indexEntry);
        $ids = array_map(function(Node $v) { return spl_object_hash($v); }, $indexEntry);
        $this->assertContains(spl_object_hash($this->__nodesObjects[0]), $ids);
        $this->assertContains(spl_object_hash($this->__nodesObjects[14]), $ids);

        foreach (['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'] as $_index => $_data) {
            $_indexEntry = $index[sha1($_data)];
            $this->assertCount(1, $_indexEntry);
            $this->assertSame($this->__nodesObjects[$_index + 1], $_indexEntry[0]);
        }
    }

    /**
     * Index a tree using the tree that has been created by objects injections.
     * Nodes have been instantiated prior to the tree's creation.
     * Indexes points to (single) nodes.
     */
    public function testIndexObjectsUnique() {
        $index = $this->__treeByObjects->index(null, true); // IDs are SHA1(data).
        $this->assertCount(14, $index);

        for ($_i=0; $_i<count($this->__nodesData); $_i++) {
            $_data = $this->__nodesData[$_i];
            $_id = sha1($_data);
            /** @var Node $_node */
            $_node = $index[$_id];
            /** @var Node $_expectedNode */
            $_expectedNode = $_data == 'A' ? $this->__nodesObjects[14] : $this->__nodesObjects[$_i];
            $this->assertSame($_expectedNode, $_node);
        }
    }

    /**
     * Check that the method used to check whether a node is a descendant of another node works as expected.
     */
    public function testIsDescendantOf() {

        /**
         * @var Node $A
         * @var Node $AA
         * @var Node $B
         * @var Node $C
         * @var Node $D
         */

        $found = $this->__treeByData->search('A');
        $this->assertEquals(count($found), 2);
        $A = $found[0];
        $AA = $found[1];

        $found = $this->__treeByData->search('B');
        $this->assertEquals(count($found), 1);
        $B = $found[0];

        $found = $this->__treeByData->search('C');
        $this->assertEquals(count($found), 1);
        $C = $found[0];

        $found = $this->__treeByData->search('D');
        $this->assertEquals(count($found), 1);
        $D = $found[0];

        $this->assertTrue($B->isDescendantOf($A));
        $this->assertTrue($C->isDescendantOf($A));
        $this->assertTrue($D->isDescendantOf($A));

        $this->assertFalse($A->isDescendantOf($A));
        $this->assertFalse($A->isDescendantOf($B));
        $this->assertFalse($A->isDescendantOf($C));
        $this->assertFalse($A->isDescendantOf($D));

        $this->assertTrue($AA->isDescendantOf($A));
        $this->assertFalse($AA->isDescendantOf($B));
        $this->assertFalse($AA->isDescendantOf($C));
        $this->assertTrue($AA->isDescendantOf($D));

        $this->assertFalse($B->isDescendantOf($B));
        $this->assertFalse($B->isDescendantOf($C));
        $this->assertFalse($B->isDescendantOf($D));

        $this->assertFalse($C->isDescendantOf($B));
        $this->assertFalse($C->isDescendantOf($C));
        $this->assertFalse($C->isDescendantOf($D));

        $this->assertFalse($D->isDescendantOf($B));
        $this->assertFalse($D->isDescendantOf($C));
        $this->assertFalse($D->isDescendantOf($D));
    }

    /**
     * Check that the method used to check whether a node is an ascendant of another node works as expected.
     */
    public function testIsAscendantOf() {

        /**
         * @var Node $A
         * @var Node $AA
         * @var Node $B
         * @var Node $C
         * @var Node $D
         */

        $found = $this->__treeByData->search('A');
        $this->assertEquals(count($found), 2);
        $A = $found[0];
        $AA = $found[1];

        $found = $this->__treeByData->search('B');
        $this->assertEquals(count($found), 1);
        $B = $found[0];

        $found = $this->__treeByData->search('C');
        $this->assertEquals(count($found), 1);
        $C = $found[0];

        $found = $this->__treeByData->search('D');
        $this->assertEquals(count($found), 1);
        $D = $found[0];

        $this->assertFalse($B->isAscendantOf($A));
        $this->assertFalse($C->isAscendantOf($A));
        $this->assertFalse($D->isAscendantOf($A));

        $this->assertFalse($A->isAscendantOf($A));
        $this->assertTrue($A->isAscendantOf($B));
        $this->assertTrue($A->isAscendantOf($C));
        $this->assertTrue($A->isAscendantOf($D));

        $this->assertFalse($AA->isAscendantOf($A));
        $this->assertFalse($AA->isAscendantOf($B));
        $this->assertFalse($AA->isAscendantOf($C));
        $this->assertFalse($AA->isAscendantOf($D));

        $this->assertFalse($B->isAscendantOf($B));
        $this->assertFalse($B->isAscendantOf($C));
        $this->assertFalse($B->isAscendantOf($D));

        $this->assertFalse($C->isAscendantOf($B));
        $this->assertFalse($C->isAscendantOf($C));
        $this->assertFalse($C->isAscendantOf($D));

        $this->assertFalse($D->isAscendantOf($B));
        $this->assertFalse($D->isAscendantOf($C));
        $this->assertFalse($D->isAscendantOf($D));
    }

    /**
     * Check that the method used to check whether a child of another node works as expected.
     */
    public function testIsChildOf()
    {

        /**
         * @var Node $root
         * @var Node $A
         * @var Node $AA
         * @var Node $B
         * @var Node $C
         * @var Node $D
         * @var Node $E
         * @var Node $J
         */

        $root = $this->__treeByData->getRoot();

        $found = $this->__treeByData->search('A');
        $this->assertEquals(count($found), 2);
        $A = $found[0];
        $AA = $found[1];

        $found = $this->__treeByData->search('B');
        $this->assertEquals(count($found), 1);
        $B = $found[0];

        $found = $this->__treeByData->search('C');
        $this->assertEquals(count($found), 1);
        $C = $found[0];

        $found = $this->__treeByData->search('D');
        $this->assertEquals(count($found), 1);
        $D = $found[0];

        $found = $this->__treeByData->search('E');
        $this->assertEquals(count($found), 1);
        $E = $found[0];

        $found = $this->__treeByData->search('J');
        $this->assertEquals(count($found), 1);
        $J = $found[0];


        $this->assertTrue($B->isChildOf($A));
        $this->assertTrue($C->isChildOf($A));
        $this->assertTrue($D->isChildOf($A));
        $this->assertTrue($E->isChildOf($D));
        $this->assertTrue($J->isChildOf($D));


        $this->assertFalse($A->isChildOf($root));
        $this->assertFalse($B->isChildOf($AA));
        $this->assertFalse($C->isChildOf($AA));
        $this->assertFalse($D->isChildOf($AA));
        $this->assertFalse($E->isChildOf($AA));
        $this->assertFalse($J->isChildOf($AA));

        // ... It's OK
    }

    public function testIsParentOf() {

        /**
         * @var Node $root
         * @var Node $A
         * @var Node $AA
         * @var Node $B
         * @var Node $C
         * @var Node $D
         * @var Node $E
         * @var Node $J
         */

        $root = $this->__treeByData->getRoot();

        $found = $this->__treeByData->search('A');
        $this->assertEquals(count($found), 2);
        $A = $found[0];
        $AA = $found[1];

        $found = $this->__treeByData->search('B');
        $this->assertEquals(count($found), 1);
        $B = $found[0];

        $found = $this->__treeByData->search('C');
        $this->assertEquals(count($found), 1);
        $C = $found[0];

        $found = $this->__treeByData->search('D');
        $this->assertEquals(count($found), 1);
        $D = $found[0];

        $found = $this->__treeByData->search('E');
        $this->assertEquals(count($found), 1);
        $E = $found[0];

        $found = $this->__treeByData->search('J');
        $this->assertEquals(count($found), 1);
        $J = $found[0];

        $this->assertTrue($A->isParentOf($B));
        $this->assertTrue($A->isParentOf($C));
        $this->assertTrue($A->isParentOf($D));
        $this->assertTrue($D->isParentOf($E));
        $this->assertTrue($D->isParentOf($J));

        $this->assertFalse($A->isParentOf($root));
        $this->assertFalse($B->isParentOf($A));
        $this->assertFalse($C->isParentOf($A));
        $this->assertFalse($D->isParentOf($A));
        $this->assertFalse($B->isParentOf($B));
        $this->assertFalse($J->isParentOf($D));

        // ... It's OK
    }


}