<?php

/**
 * This example illustrates various operations on nodes.
 */

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use dbeurive\Tree\Tree;
use dbeurive\Tree\Node;

$root = new Node("root");
$A    = new Node("A");
$AA   = new Node("A");
$B    = new Node("B");
$C    = new Node("C");
$D    = new Node("D");
$E    = new Node("E");
$EE   = new Node("EE");
$EEE  = new Node("EEE");
$F    = new Node("F");
$H    = new Node("H");
$I    = new Node("I");
$J    = new Node("J");
$K    = new Node("K");
$L    = new Node("L");


$tree = new Tree($root);
$tree->getRoot()
            ->addChild($A)->end()
            ->addChild($B)->end()
            ->addChild($C)
                ->addChild($D)
                    ->addChild($E)
                        ->addChild($EE)->end()
                        ->addChild($EEE)->end()
                    ->end()
                    ->addChild($F)->end()
                ->end()
                ->addChild($AA)
                    ->addChild($H)
                        ->addChild($I)
                            ->addChild($J)
                                ->addChild($K)->end()
                                ->addChild($L)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

// ---------------------------------------------------------------------------------------------------------------------
// Testing ancestry
// ---------------------------------------------------------------------------------------------------------------------

print "Is <" . $root->getData() . "> an ascendant of <" . $L->getData() . "> ? " . ($root->isAscendantOf($L) ? 'yes' : 'no') . "\n";
print "Is <" . $root->getData() . "> an ascendant of <" . $F->getData() . "> ? " . ($root->isAscendantOf($F) ? 'yes' : 'no') . "\n";
print "Is <" . $L->getData() . "> an ascendant of <" . $K->getData() . "> ? " . ($L->isAscendantOf($K) ? 'yes' : 'no') . "\n";

// ---------------------------------------------------------------------------------------------------------------------
// Testing  descendance
// ---------------------------------------------------------------------------------------------------------------------

print "Is <" . $root->getData() . "> a descendant of <" . $L->getData() . "> ? " . ($root->isDescendantOf($L) ? 'yes' : 'no') . "\n";
print "Is <" . $root->getData() . "> a descendant of <" . $F->getData() . "> ? " . ($root->isDescendantOf($F) ? 'yes' : 'no') . "\n";
print "Is <" . $L->getData() . "> a descendant of <" . $K->getData() . "> ? " . ($L->isDescendantOf($K) ? 'yes' : 'no') . "\n";

// ---------------------------------------------------------------------------------------------------------------------
// Is a node the parent of another node ?
// ---------------------------------------------------------------------------------------------------------------------

print "Is <" . $root->getData() . "> the parent of <" . $A->getData() . "> ? " . ($root->isParentOf($A) ? 'yes' : 'no') . "\n";
print "Is <" . $root->getData() . "> the parent of <" . $B->getData() . "> ? " . ($root->isParentOf($B) ? 'yes' : 'no') . "\n";
print "Is <" . $root->getData() . "> the parent of <" . $J->getData() . "> ? " . ($root->isParentOf($J) ? 'yes' : 'no') . "\n";

// ---------------------------------------------------------------------------------------------------------------------
// Is a node a child of another node ?
// ---------------------------------------------------------------------------------------------------------------------

print "Is <" . $A->getData() . "> a child of <" . $root->getData() . "> ? " . ($A->isChildOf($root) ? 'yes' : 'no') . "\n";
print "Is <" . $C->getData() . "> a child of <" . $root->getData() . "> ? " . ($C->isChildOf($root) ? 'yes' : 'no') . "\n";
print "Is <" . $D->getData() . "> a child of <" . $C->getData() . "> ? " . ($A->isChildOf($C) ? 'yes' : 'no') . "\n";
print "Is <" . $L->getData() . "> a child of <" . $C->getData() . "> ? " . ($L->isChildOf($C) ? 'yes' : 'no') . "\n";

// ---------------------------------------------------------------------------------------------------------------------
// Test if sibling.
// ---------------------------------------------------------------------------------------------------------------------

print "Is <" . $A->getData() . "> a sibling of <" . $B->getData() . "> ? " . ($A->isSiblingWith($B) ? 'yes' : 'no') . "\n";
print "Is <" . $EE->getData() . "> a sibling of <" . $EEE->getData() . "> ? " . ($EE->isSiblingWith($EEE) ? 'yes' : 'no') . "\n";

// ---------------------------------------------------------------------------------------------------------------------
// Get all the children of a node.
// ---------------------------------------------------------------------------------------------------------------------

/** @var Node $_child */
print "The children of " . $root->getData() . " are: \n";
foreach ($root->getChildren() as $_child) {
    print " - " . $_child->getData() . "\n";
}

// ---------------------------------------------------------------------------------------------------------------------
// Get the parent of a node.
// ---------------------------------------------------------------------------------------------------------------------

$parent = $L->getParent();
print "The parent of " . $L->getData() . " is " . $parent->getData() . "\n";

// ---------------------------------------------------------------------------------------------------------------------
// Get the siblings.
// ---------------------------------------------------------------------------------------------------------------------

$siblings = $A->getSiblings();
/** @var Node $_sibling */
print "Siblings for the node A:\n";
foreach ($siblings as $_sibling) {
    print " - " . $_sibling->getData() . "\n";
}

