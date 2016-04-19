<?php

use dbeurive\Tree;
use dbeurive\Tree\Node;

class NodeTest extends PHPUnit_Framework_TestCase
{
    protected function setUp() {

    }

    /**
     * Tests the iteration over nodes' children.
     */
    public function testIterator() {

        $datas = ['B', 'C', 'D'];

        $node = new Node('A');
        for ($i=0; $i<count($datas); $i++) {
            $node->addChild($datas[$i]);
        }

        /**
         * @var int $_index
         * @var Node $_child
         */
        foreach ($node as $_index => $_child) {
            $this->assertEquals($datas[$_index], $_child->getData());
        }
    }

    /**
     * Tests that the method isLeaf() works as expected.
     */
    public function testIsLeaf() {

        $nodeA = new Node('A'); // Root
        $nodeB = new Node('B'); // Not a leaf
        $nodeC = new Node('C'); // Not a leaf
        $nodeD = new Node('D'); // Not a leaf
        $nodeE = new Node('E'); // Leaf
        $nodeF = new Node('F'); // Leaf

        $nodeA->addChild($nodeB)->addChild($nodeC)->addChild($nodeD);
        $nodeD->addChild($nodeE);
        $nodeB->addChild($nodeF);

        $this->assertTrue($nodeE->isLeaf());
        $this->assertTrue($nodeF->isLeaf());

        $this->assertFalse($nodeA->isLeaf());
        $this->assertFalse($nodeB->isLeaf());
        $this->assertFalse($nodeC->isLeaf());
        $this->assertFalse($nodeD->isLeaf());
    }

    /**
     * Tests that the method hasChildren() works as expected.
     */
    public function testHasChildren() {

        $nodeA = new Node('A'); // Has children
        $nodeB = new Node('B'); // Has children
        $nodeC = new Node('C'); // Has children
        $nodeD = new Node('D'); // Has children
        $nodeE = new Node('E'); // Does not have children
        $nodeF = new Node('F'); // Does not have children

        $nodeA->addChild($nodeB)->addChild($nodeC)->addChild($nodeD);
        $nodeD->addChild($nodeE);
        $nodeB->addChild($nodeF);

        $this->assertTrue($nodeA->hasChildren());
        $this->assertTrue($nodeB->hasChildren());
        $this->assertTrue($nodeC->hasChildren());
        $this->assertTrue($nodeD->hasChildren());

        $this->assertFalse($nodeE->hasChildren());
        $this->assertFalse($nodeF->hasChildren());
    }

    /**
     * Tests that the method isRoot() works as expected.
     */
    public function testIsRoot() {

        $nodeA = new Node('A'); // Is root
        $nodeB = new Node('B'); // Is not root
        $nodeC = new Node('C'); // Is not root
        $nodeD = new Node('D'); // Is not root
        $nodeE = new Node('E'); // Is not root
        $nodeF = new Node('F'); // Is not root

        $nodeA->addChild($nodeB)->addChild($nodeC)->addChild($nodeD);
        $nodeD->addChild($nodeE);
        $nodeB->addChild($nodeF);

        $this->assertTrue($nodeA->isRoot());

        $this->assertFalse($nodeB->isRoot());
        $this->assertFalse($nodeC->isRoot());
        $this->assertFalse($nodeD->isRoot());
        $this->assertFalse($nodeE->isRoot());
        $this->assertFalse($nodeF->isRoot());
    }

    /**
     * Tests that the method isRoot() works as expected.
     */
    public function testHasParent() {

        $nodeA = new Node('A'); // Does not have parent
        $nodeB = new Node('B'); // Has parent
        $nodeC = new Node('C'); // Has parent
        $nodeD = new Node('D'); // Has parent
        $nodeE = new Node('E'); // Has parent
        $nodeF = new Node('F'); // Has parent

        $nodeA->addChild($nodeB)->addChild($nodeC)->addChild($nodeD);
        $nodeD->addChild($nodeE);
        $nodeB->addChild($nodeF);

        $this->assertTrue($nodeB->hasParent());
        $this->assertTrue($nodeC->hasParent());
        $this->assertTrue($nodeD->hasParent());
        $this->assertTrue($nodeE->hasParent());
        $this->assertTrue($nodeF->hasParent());

        $this->assertFalse($nodeA->hasParent());
    }

    /**
     * Tests that the method isDescendantOf() works as expected.
     */
    public function testIsDescendantOf() {

        $nodeA = new Node('A'); // Is not a child
        $nodeB = new Node('B'); // Is the child of A
        $nodeC = new Node('C'); // Is the child of B
        $nodeD = new Node('D'); // Is the child of C
        $nodeE = new Node('E'); // Is the child of D
        $nodeF = new Node('F'); // Is the child of B

        $nodeA->addChild($nodeB)->addChild($nodeC)->addChild($nodeD);
        $nodeD->addChild($nodeE);
        $nodeB->addChild($nodeF);

        // Direct relationship
        $this->assertTrue($nodeB->isDescendantOf($nodeA));
        $this->assertTrue($nodeC->isDescendantOf($nodeB));
        $this->assertTrue($nodeD->isDescendantOf($nodeC));
        $this->assertTrue($nodeE->isDescendantOf($nodeD));
        $this->assertTrue($nodeF->isDescendantOf($nodeB));

        // Distant relationship
        $this->assertTrue($nodeC->isDescendantOf($nodeA));
        $this->assertTrue($nodeD->isDescendantOf($nodeA));
        $this->assertTrue($nodeE->isDescendantOf($nodeA));
        $this->assertTrue($nodeF->isDescendantOf($nodeA));

        $this->assertFalse($nodeA->isDescendantOf($nodeA));
        $this->assertFalse($nodeA->isDescendantOf($nodeB));
        $this->assertFalse($nodeA->isDescendantOf($nodeC));
        $this->assertFalse($nodeA->isDescendantOf($nodeD));
        $this->assertFalse($nodeA->isDescendantOf($nodeE));
        $this->assertFalse($nodeA->isDescendantOf($nodeF));

        $this->assertFalse($nodeB->isDescendantOf($nodeB));
        $this->assertFalse($nodeB->isDescendantOf($nodeC));
        $this->assertFalse($nodeB->isDescendantOf($nodeD));
        $this->assertFalse($nodeB->isDescendantOf($nodeE));
        $this->assertFalse($nodeB->isDescendantOf($nodeF));

        $this->assertFalse($nodeC->isDescendantOf($nodeC));
        $this->assertFalse($nodeC->isDescendantOf($nodeD));
        $this->assertFalse($nodeC->isDescendantOf($nodeE));
        $this->assertFalse($nodeC->isDescendantOf($nodeF));

        $this->assertFalse($nodeD->isDescendantOf($nodeD));
        $this->assertFalse($nodeD->isDescendantOf($nodeE));
        $this->assertFalse($nodeD->isDescendantOf($nodeF));
    }

    /**
     * Tests that the method isChildOf() works as expected.
     */
    public function testIsChildOf() {

        $nodeA = new Node('A'); // Is not a child
        $nodeB = new Node('B'); // Is the child of A
        $nodeC = new Node('C'); // Is the child of B
        $nodeD = new Node('D'); // Is the child of C
        $nodeE = new Node('E'); // Is the child of D
        $nodeF = new Node('F'); // Is the child of B
        $nodeG = new Node('G'); // Is the child of A

        $nodeA->addChild($nodeB)->addChild($nodeC)->addChild($nodeD);
        $nodeA->addChild($nodeG);
        $nodeD->addChild($nodeE);
        $nodeB->addChild($nodeF);

        $this->assertTrue($nodeB->isChildOf($nodeA));
        $this->assertTrue($nodeG->isChildOf($nodeA));
        $this->assertTrue($nodeC->isChildOf($nodeB));
        $this->assertTrue($nodeD->isChildOf($nodeC));
        $this->assertTrue($nodeE->isChildOf($nodeD));
        $this->assertTrue($nodeF->isChildOf($nodeB));

        $this->assertFalse($nodeA->isChildOf($nodeB));
        $this->assertFalse($nodeA->isChildOf($nodeG));
        $this->assertFalse($nodeB->isChildOf($nodeC));
        $this->assertFalse($nodeC->isChildOf($nodeD));
        $this->assertFalse($nodeD->isChildOf($nodeE));
        $this->assertFalse($nodeB->isChildOf($nodeF));
    }

    /**
     * Tests that the method isParentOf() works as expected.
     */
    public function testIsParentOf() {

        $nodeA = new Node('A'); // Is not a child
        $nodeB = new Node('B'); // Is the child of A
        $nodeC = new Node('C'); // Is the child of B
        $nodeD = new Node('D'); // Is the child of C
        $nodeE = new Node('E'); // Is the child of D
        $nodeF = new Node('F'); // Is the child of B
        $nodeG = new Node('G'); // Is the child of A

        $nodeA->addChild($nodeB)->addChild($nodeC)->addChild($nodeD);
        $nodeA->addChild($nodeG);
        $nodeD->addChild($nodeE);
        $nodeB->addChild($nodeF);

        $this->assertTrue($nodeA->isParentOf($nodeB));
        $this->assertTrue($nodeA->isParentOf($nodeG));
        $this->assertTrue($nodeB->isParentOf($nodeC));
        $this->assertTrue($nodeC->isParentOf($nodeD));
        $this->assertTrue($nodeD->isParentOf($nodeE));
        $this->assertTrue($nodeB->isParentOf($nodeF));

        $this->assertFalse($nodeB->isParentOf($nodeA));
        $this->assertFalse($nodeG->isParentOf($nodeA));
        $this->assertFalse($nodeC->isParentOf($nodeB));
        $this->assertFalse($nodeD->isParentOf($nodeC));
        $this->assertFalse($nodeE->isParentOf($nodeD));
        $this->assertFalse($nodeF->isParentOf($nodeB));
    }

    /**
     * Tests that the function isSiblingWith() works as expected.
     */
    public function testIsSiblingWith() {
        $nodeA = new Node('A');
        $nodeB = new Node('B');
        $nodeC = new Node('C');
        $nodeD = new Node('D');
        $nodeE = new Node('E');
        $nodeF = new Node('F');
        $nodeG = new Node('G');

        $nodeA->addChild($nodeB);
        $nodeA->addChild($nodeC);
        $nodeA->addChild($nodeD);

        $nodeD->addChild($nodeE);
        $nodeD->addChild($nodeF);
        $nodeD->addChild($nodeG);

        $this->assertTrue($nodeB->isSiblingWith($nodeC));
        $this->assertTrue($nodeC->isSiblingWith($nodeB));
        $this->assertTrue($nodeD->isSiblingWith($nodeB));
        $this->assertTrue($nodeB->isSiblingWith($nodeD));
        $this->assertTrue($nodeC->isSiblingWith($nodeD));
        $this->assertTrue($nodeD->isSiblingWith($nodeC));

        $this->assertFalse($nodeD->isSiblingWith($nodeE));
        $this->assertFalse($nodeD->isSiblingWith($nodeF));
        $this->assertFalse($nodeD->isSiblingWith($nodeG));
    }

    /**
     * Tests that the method getSiblings() works as expected.
     */
    public function testGetSiblings() {
        $nodeA = new Node('A');
        $nodeB = new Node('B');
        $nodeC = new Node('C');
        $nodeD = new Node('D');
        $nodeE = new Node('E');
        $nodeF = new Node('F');
        $nodeG = new Node('G');

        $nodeA->addChild($nodeB);
        $nodeA->addChild($nodeC);
        $nodeA->addChild($nodeD);

        $nodeD->addChild($nodeE);
        $nodeD->addChild($nodeF);
        $nodeD->addChild($nodeG);

        $s = $nodeB->getSiblings();
        $this->assertCount(2, $s);
        $this->assertInternalType("int", array_search($nodeC, $s)); // array_search could return FALSE.
        $this->assertInternalType("int", array_search($nodeD, $s)); // array_search could return FALSE.
        $this->assertFalse(array_search($nodeF, $s));

        $s = $nodeE->getSiblings();
        $this->assertCount(2, $s);
        $this->assertInternalType("int", array_search($nodeF, $s)); // array_search could return FALSE.
        $this->assertInternalType("int", array_search($nodeG, $s)); // array_search could return FALSE.
        $this->assertFalse(array_search($nodeA, $s));
    }

    /**
     * Tests that the method isAscendantOf() works as expected.
     */
    public function testIsAscendantOf() {

        $nodeA = new Node('A'); // Is parent of B, C, D, E, F
        $nodeB = new Node('B'); // Is parent of C, D, E, F
        $nodeC = new Node('C'); // Is parent of D
        $nodeD = new Node('D'); // Is parent of E
        $nodeE = new Node('E'); // Is not a parent
        $nodeF = new Node('F'); // Is not a parent

        $nodeA->addChild($nodeB)->addChild($nodeC)->addChild($nodeD);
        $nodeD->addChild($nodeE);
        $nodeB->addChild($nodeF);

        // Is parent of...

        $this->assertTrue($nodeA->isAscendantOf($nodeB));
        $this->assertTrue($nodeA->isAscendantOf($nodeC));
        $this->assertTrue($nodeA->isAscendantOf($nodeD));
        $this->assertTrue($nodeA->isAscendantOf($nodeE));
        $this->assertTrue($nodeA->isAscendantOf($nodeF));

        $this->assertTrue($nodeB->isAscendantOf($nodeC));
        $this->assertTrue($nodeB->isAscendantOf($nodeD));
        $this->assertTrue($nodeB->isAscendantOf($nodeE));
        $this->assertTrue($nodeB->isAscendantOf($nodeF));

        $this->assertTrue($nodeC->isAscendantOf($nodeD));

        $this->assertTrue($nodeD->isAscendantOf($nodeE));

        // Is not parent of...

        $this->assertFalse($nodeA->isAscendantOf($nodeA));
        $this->assertFalse($nodeB->isAscendantOf($nodeB));
        $this->assertFalse($nodeC->isAscendantOf($nodeC));
        $this->assertFalse($nodeD->isAscendantOf($nodeD));
        $this->assertFalse($nodeE->isAscendantOf($nodeE));
        $this->assertFalse($nodeF->isAscendantOf($nodeF));

        $this->assertFalse($nodeE->isAscendantOf($nodeA));
        $this->assertFalse($nodeE->isAscendantOf($nodeB));
        $this->assertFalse($nodeE->isAscendantOf($nodeC));
        $this->assertFalse($nodeE->isAscendantOf($nodeD));
        $this->assertFalse($nodeE->isAscendantOf($nodeF));

        $this->assertFalse($nodeF->isAscendantOf($nodeA));
        $this->assertFalse($nodeF->isAscendantOf($nodeB));
        $this->assertFalse($nodeF->isAscendantOf($nodeC));
        $this->assertFalse($nodeF->isAscendantOf($nodeD));
        $this->assertFalse($nodeF->isAscendantOf($nodeE));

        // ... It's OK. We could generate all the possible combinations... but it is not necessary.
    }

    /**
     * Tests that the method testParent() works as expected.
     */
    public function testParent() {
        $nodeA = new Node('A'); // Does not have parent.
        $nodeB = new Node('B'); // Parent is A
        $nodeC = new Node('C'); // Parent is B
        $nodeD = new Node('D'); // Parent is C
        $nodeE = new Node('E'); // Parent is D
        $nodeF = new Node('F'); // Parent is B

        $nodeA->addChild($nodeB)->addChild($nodeC)->addChild($nodeD);
        $nodeD->addChild($nodeE);
        $nodeB->addChild($nodeF);

        $this->assertNull($nodeA->getParent());
        $this->assertSame($nodeB->getParent(), $nodeA);
        $this->assertSame($nodeC->getParent(), $nodeB);
        $this->assertSame($nodeD->getParent(), $nodeC);
        $this->assertSame($nodeE->getParent(), $nodeD);
        $this->assertSame($nodeF->getParent(), $nodeB);

        $this->assertNotSame($nodeB->getParent(), $nodeC);
        $this->assertNotSame($nodeC->getParent(), $nodeD);
        $this->assertNotSame($nodeD->getParent(), $nodeE);
        $this->assertNotSame($nodeE->getParent(), $nodeF);
        $this->assertNotSame($nodeF->getParent(), $nodeA);

        // It's OK.
    }

}