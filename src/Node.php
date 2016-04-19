<?php

/**
* This file contains the implementation of the class "Node".
*/


namespace dbeurive\Tree;

/**
 * Class Node
 *
 * This class implements a tree's node.
 *
 * @package dbeurive\Tree
 */

class Node implements \Iterator
{
    /**
     * @var Node|null Parent node.
     */
    private $__parent = null;
    /**
     * @var array List of node's children.
     */
    private $__children = [];
    /**
     * @var mixed Node's data.
     */
    private $__data = null;
    /**
     * @var int This property is used to implement the Iterator interface.
     */
    private $__position = 0;

    /**
     * Create a new node.
     * @param mixed|null $inData Data that will be assigned to the node.
     * @param Node|null $inParent Parent node. If the given value is null, then no parent not is assigned to the new node.
     */
    public function __construct($inData=null, Node $inParent=null) {
        if (! is_null($inData)) {
            $this->__data = $inData;
        }
        if (! is_null($inParent)) {
            $this->__parent = $inParent;
        }
    }

    // -----------------------------------------------------------------------------------------------------------------
    // BUILDER
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * This method is part of the tree builder. Add a child to a given node.
     * @param mixed|Node $inDataOrNodeInstance Depending on the given value:
     *          * If the given value is an instance of Node, then the given node is assigned as a child of the current node.
     *          * Otherwise, a new instance of `\dbeurive\Tree\Node` is created using the given value as data.
     *            And the newly created node becomes a child of the current node.
     *        </ul>* @return Node The method returns the newly create child node.
     */
    public function addChild($inDataOrNodeInstance) {
        $c = $inDataOrNodeInstance instanceof Node ? $inDataOrNodeInstance : new Node($inDataOrNodeInstance);
        $c->setParent($this);
        $this->__children[] = $c;
        return $c;
    }

    /**
     * This method is part of the tree builder. It is used to declare a node as leaf.
     * @return Node|null The method returns the node's parent.
     */
    public function end() {
        return $this->__parent;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // SETTERS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Set the node's data.
     * @param mixed $inData Data to set.
     * @return $this
     */
    public function setData($inData) {
        $this->__data = $inData;
        return $this;
    }

    /**
     * Set the parent's node.
     * @param Node $inNode The parent's node.
     * @return $this
     */
    public function setParent(Node $inNode) {
        $this->__parent = $inNode;
        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // GETTERS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Return the node's parent, or null if the current node is the Tree's root.
     * @return Node|null The method returns the node's parent, or `null` if the current node is the tree's root.
     */
    public function getParent() {
        return $this->__parent;
    }

    /**
     * Return the node's children.
     * @return array The method returns the node's children.
     */
    public function getChildren() {
        return $this->__children;
    }

    /**
     * Return the node's data.
     * @return mixed|null The method returns the node's data.
     */
    public function getData() {
        return $this->__data;
    }

    /**
     * Return the node' siblings.
     * @return array The method returns a array that contains the siblings.
     */
    public function getSiblings() {
        $parent = $this->getParent();
        if (is_null($parent)) {
            // This is the root node.
            return [];
        }

        $children = $parent->getChildren();
        $index = array_search($this, $children);
        unset($children[$index]);
        return $children;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // TESTS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Test if the node is a leaf.
     * @return bool If the node is a leaf, then the method returns the value `true`.
     *         Otherwise, the method returns the value `false`.
     */
    public function isLeaf() {
        return count($this->__children) == 0;
    }

    /**
     * Test if the node is the tree's root.
     * @return bool If the node is the tree's root, then the method returns the value `true`.
     *         Otherwise, the method returns the value `false`.
     */
    public function isRoot() {
        return is_null($this->getParent());
    }

    /**
     * Test if the node has children.
     * @return bool If the node has children, then the method returns the value `true`.
     *         Otherwise, the method returns the value `false`.
     */
    public function hasChildren() {
        return ! $this->isLeaf();
    }

    /**
     * Test if the node has a parent.
     * @return bool If the node has a parent, then the method returns the value `true`.
     *         Otherwise, the method returns the value `false`.
     */
    public function hasParent() {
        return ! $this->isRoot();
    }

    /**
     * Test if the node is a the child of a given potential parent node.
     * @param Node $inNode Potential parent node.
     * @return bool If the node is a child of the given node, then the method returns the value `true`.
     *         Otherwise, the method returns the value `false`.
     *
     *         If tree is A -> B -> C
     *         Then - C is a child of B.
     *              - C is NOT a child of A.
     *              - B is a child of A.
     */
    public function isChildOf(Node $inNode) {
        if ($this->hasParent()) {
            return $this->getParent() === $inNode;
        }
        return false;
    }

    /**
     * Test if the node is a descendant of a given potential (ascendant) node.
     * @param Node $inNode Potential ascendant node.
     * @return bool If the node is a descendant of the given node, then the method returns the value `true`.
     *         Otherwise, the method returns the value `false`.
     *
     *         If tree is A -> B -> C
     *         Then - C is a descendant of A and B.
     *              - B is a descendant of A.
     */
    public function isDescendantOf(Node $inNode) {
        $node = $this;
        while ($node->hasParent()) {
            $node = $node->getParent();
            if ($node === $inNode) {
                return true;
            }
        }
        return false;
    }

    /**
     * Test if the node is a the parent of a given potential (child) node.
     * @param Node $inNode Potential child node.
     * @return bool If the node is the parent of the given node, then the method returns the value `true`.
     *         Otherwise, the method returns the value `false`.
     *
     *         If tree is A -> B -> C
     *         Then - C is not a parent.
     *              - B is the parent of C.
     *              - A is the parent of B.
     */
    public function isParentOf(Node $inNode) {
        foreach ($this->getChildren() as $_child) {
            if ($inNode === $_child) {
                return true;
            }
        }
        return false;
    }

    /**
     * Test if the node is an ascendant of a given potential (descendant) node.
     * @param Node $inNode Potential descendant node.
     * @return bool If the node is an ascendant of the given node, then the method returns the value `true`.
     *         Otherwise, the method returns the value `false`.
     *
     *         If tree is A -> B -> C
     *         Then - A is an ascendant for B and C.
     *              - B is an ascendant for C.
     */
    public function isAscendantOf(Node $inNode) {
        $result = [ 'found' => false ];
        $compare = function(Node $inCurrentNode, &$inOutResult) use ($inNode) {
            if ($inOutResult['found']) {
                return;
            }
            if ($inCurrentNode === $inNode) {
                $inOutResult['found'] = true;
            }
        };
        if ($this->hasChildren()) {
            foreach ($this->getChildren() as $_child) {
                /** @var Node $_child */
                $_child->traverse($compare, $result);
            }
            return $result['found'];
        }
        return false;
    }

    /**
     * Test if the node is a sibling of a given node.
     * @param Node $inNode Node to compare with.
     * @return bool If the node is a sibling of the given node, then the method returns the value `true`.
     *         Otherwise, it returns the value `false`.
     */
    public function isSiblingWith(Node $inNode) {
        return $this->getParent() === $inNode->getParent();
    }

    // -----------------------------------------------------------------------------------------------------------------
    // EXPLOITATION
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Walk through all children of a given node.
     * @param callable $inFunction Function to execute on every encountered node.
     *        The signature of the function must be: `void function(Node $inNode, &$inOutResult)`
     *          * $inNode: node upon which the function executes.
     *          * $inOutResult Array used to store and organize permanent data between the user's provided function calls.
     * @param array $inOutResult Array used to store and organize permanent data between the user's provided function calls.
     */
    public function traverse(callable $inFunction, array &$inOutResult)
    {
        // We pass through a node. Therefore we call the user provided function on this node.
        $inFunction($this, $inOutResult);

        // Then we head for each child of the current node.
        foreach ($this as $child) {
            /** @var Node $child */
            if ($child->hasChildren()) {
                // The current child has children. Then let's go through it.
                $child->traverse($inFunction, $inOutResult);

                // As long as we encounter a child, we call the method recursively. Thus the method's execution's contexts pile up.
                // However, as soon as we encounter a leaf, we start to continue the execution of all previously piled up method's execution's contexts.
                // Once all piled up execution's contexts have ended, we walk through the next child.
                continue;
            }

            // The child node does not have children. This is a leaf.
            $inFunction($child, $inOutResult);
        }
    }

    // -------------------------------------------------------------------------
    // Implement the Iterator's interface.
    // -------------------------------------------------------------------------

    /**
     * Implementation of the interface \Iterator
     */
    public function current() {
        return $this->__children[$this->__position];
    }

    /**
     * Implementation of the interface \Iterator
     */
    public function key() {
        return $this->__position;
    }

    /**
     * Implementation of the interface \Iterator
     */
    public function next() {
        return ++$this->__position;
    }

    /**
     * Implementation of the interface \Iterator
     */
    public function rewind() {
        $this->__position = 0;
    }

    /**
     * Implementation of the interface \Iterator
     */
    public function valid() {
        return isset($this->__children[$this->__position]);
    }


}