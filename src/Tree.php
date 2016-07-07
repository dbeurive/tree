<?php

/**
 * This file contains the implementation of the class "Tree".
 */

namespace dbeurive\Tree;

/**
 * class Tree
 *
 * This class implements a tree.
 *
 * @package dbeurive\Tree
 */

class Tree
{
    /**
     * @var Node|null Root node.
     */
    private $__root = null;
    /** @var callable|null Function used to get a label from a node. */
    private $__dataToStringConverter = null;
    /** @var callable|null Function used to compare data. */
    private $__dataComparator = null;
    /** @var callable|null Function used to get a unique ID from a node's data. */
    private $__dataIndexBuilder = null;

    /**
     * Return a new tree.
     * @param mixed|Node $inDataOrNodeInstance Depending on the given value:
     *          * If the given value is an instance of `\dbeurive\Tree\Node`, then the provided node is set as the root node for the tree.
     *          * If the given value is not null, and is not an instance of `\dbeurive\Tree\Node`, then a new instance of `\dbeurive\Tree\Node` is created using the given value as data.
     *            Then, this newly created node is set as the root node for the tree.
     *          * If the given value is null, then the tree is created without root node.
     */
    public function __construct($inDataOrNodeInstance=null) {
        if (! is_null($inDataOrNodeInstance)) {
            $this->__root = $inDataOrNodeInstance instanceof Node ? $inDataOrNodeInstance : new Node($inDataOrNodeInstance);
        }

        // Set default functions.
        $this->__dataToStringConverter = function($inData) {
            return $inData;
        };
        $this->__dataComparator = function($inDataLeft, $inDataRight) {
            return $inDataLeft == $inDataRight;
        };
        $this->__dataIndexBuilder = function($inData) {
            return sha1($inData);
        };
    }

    // -----------------------------------------------------------------------------------------------------------------
    // SETTERS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Set the default function used to get a printable representation of a node's data.
     * @param callable|null $inConverter Function used to get a printable representation of a given node's data.
     *        Function' signature must be: `string function($inData)`.
     *        Where the variable `$inData` represents the node's data.
     * @return $this
     */
    public function setDataToStringConverter(callable $inConverter) {
        $this->__dataToStringConverter = $inConverter;
        return $this;
    }

    /**
     * Set the default function used to compare two nodes' data.
     * @param callable $inComparator Function used to compare two nodes' data.
     *        Function' signature must be: `bool function($inData1, $inData2)`.
     *        Where `$inData1` and `$inData2` are the data to compare.
     *        * If `$inData1` is equal to `$inData2`, then the function must return the value `true`.
     *        * Otherwise, the function must return the value `false`.
     * @return $this
     */
    public function setDataComparator(callable $inComparator) {
        $this->__dataComparator = $inComparator;
        return $this;
    }

    /**
     * Set the default function used to generated an index from a given node's data.
     * @param callable $inIndexBuilder Function that generates a unique ID from a given node's data.
     *        Function' signature must be: `string function(mixed $inData)`
     *        Where `$inData` represents the node's data that we want to generate an index from.
     *        The default function is "sha1".
     * @return $this
     */
    public function setDataIndexBuilder(callable $inIndexBuilder) {
        $this->__dataIndexBuilder = $inIndexBuilder;
        return $this;
    }

    /**
     * Set the root node of the tree.
     * @param mixed|Node $inDataOrNode Depending on the given value:
     *          * If the given value is an instance of Node, then the node is set as the root node for the tree.
     *          * Otherwise, a new node is created using the given value as data. And the newly created node becomes the root node.
     * @return $this
     */
    public function setRoot($inDataOrNode) {
        $this->__root = $inDataOrNode instanceof Node ? $inDataOrNode : new Node($inDataOrNode);
        return $this;
    }

    /**
     * Create a tree from an array.
     * @param array $inArray Array that represents a tree.
     * @param callable|null $inOptDeserializer Function used to deserialize data prior to its injection into the tree.
     * @param string $inOptDataTag Key, within the arrays, that points to the node's label.
     *        Default tag is "data".
     * @param string $inOptChildrenTag Key, within the arrays, that points to the node's children.
     *        Default tag is "children".
     * @return Tree The function returns a new tree.
     * @throws \Exception
     */
    static public function fromArray(array $inArray, callable $inOptDeserializer=null, $inOptDataTag='data', $inOptChildrenTag='children') {

        if (is_null($inOptDeserializer)) {
            $inOptDeserializer = function($inSerialised) {
                return $inSerialised;
            };
        }

        $result = [ 'tree' => new Tree(), 'index' => [], 'id' => 0 ];

        $builder = function (array &$inCurrentNode, $isLeaf, &$inParentNode, array &$inOutData) use ($inOptDeserializer, $inOptDataTag, $inOptChildrenTag) {

            if (! array_key_exists($inOptDataTag, $inCurrentNode)) {
                throw new \Exception("The given array is not valid. No data defined for the current node!");
            }

            if (! array_key_exists($inOptChildrenTag, $inCurrentNode)) {
                throw new \Exception("The given array is not valid. No children defined for the current node!");
            }

            if (! is_array($inCurrentNode[$inOptChildrenTag])) {
                throw new \Exception("This given array in not a valid tree. Key $inOptChildrenTag is not an array!");
            }

            // Generate a unique ID for the current node, so it can be indexed.
            $currentNodeId = $inOutData['id'];
            $inOutData['id'] += 1;
            $inCurrentNode['id'] = $currentNodeId; // Add the ID to the array that represents the current node.

            // Special processing for the root node.
            if (is_null($inParentNode)) {
                /** @var Tree $tree */
                $tree = $inOutData['tree']; // Create this variable so we have the auto completion and the API checks.
                $root = new Node($inOptDeserializer($inCurrentNode[$inOptDataTag]));
                $tree->setRoot($root);
                $inOutData['index'][$currentNodeId] = $root;
                return;
            }

            // Note that the "parent node" has already been processed by this function.
            // Therefore, it has been assigned an ID. And the ID has been indexed.
            /** @var Node $parent */
            $parent = $inOutData['index'][$inParentNode['id']]; // Create this variable so we have the auto completion and the API checks.
            $newNode = $parent->addChild($inOptDeserializer($inCurrentNode[$inOptDataTag]));
            $inOutData['index'][$currentNodeId] = $newNode;
        };

        self::arrayTraverse($inArray, $builder, $result);
        return $result['tree'];
    }

    // -----------------------------------------------------------------------------------------------------------------
    // GETTERS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Return the root of the tree.
     * @return \dbeurive\Tree\Node|null The method returns the root of the tree.
     *         Please note that the tree may not have any attributed root node.
     *         In this case, the method returns the value `null`.
     */
    public function getRoot() {
        return $this->__root;
    }

    /**
     * Search for nodes that have a given data value within the tree.
     * @param mixed $inData Data value to look for.
     * @param int $inOptLimit Maximum number of nodes to keep.
     *        If the parameter's value is set to 0, then all found nod`es are kept.
     * @param callable|null $inOptDataComparator User provided function used to compare nodes' data.
     *          * If this parameter is omitted, then the default behavior is to use the operator "`==`" to compare data.
     *          * The signature of this function must be: `bool function(mixed $value1, mixed value2)`.
     *            If `$value1` is equal to `$value2`, then the function must return the value `true`.
     *            Otherwise the function must return the value `false`.
     * @return array The method returns an array that contains the found nodes.
     *         Each element of the returned array is an instance of `\dbeurive\Tree\Node`.
     */
    public function search($inData, $inOptLimit=0, callable $inOptDataComparator=null) {

        if (is_null($inOptDataComparator)) {
            $inOptDataComparator = $this->__dataComparator;
        }

        $result = [ 'found' => [], 'count' => 0, 'continue' => true ];
        $find = function(Node $inNode, array &$inOutResult) use ($inData, $inOptLimit, $inOptDataComparator) {
            if (! $inOutResult['continue']) {
                return;
            }

            if ($inOptDataComparator($inData, $inNode->getData())) {
                $inOutResult['found'][] = $inNode;
                $inOutResult['count'] += 1;
                if ($inOptLimit > 0) {
                    if ($inOutResult['count'] >= $inOptLimit) {
                        $inOutResult['continue'] = false;
                    }
                }
            }
        };

        $this->traverse($find, $result);
        return $result['found'];
    }

    /**
     * Select all nodes that verify a criterion.
     * @param callable $inSelector Function used to check if a node's data verifies the criterion.
     *        The signature of the function must be: `bool function(mixed $inData)`.
     *        * If the given node's data verifies the criterion, then the function must return the value `true`.
     *        * Otherwise, it must return the value `false`.
     * @param int $inOptLimit Maximum number of nodes to keep.
     *        If the parameter's value is set to 0, then all found nodes are kept.
     * @return array The method returns an array that contains the selected nodes.
     */
    public function select(callable $inSelector, $inOptLimit=0) {

        $result = [ 'found' => [], 'count' => 0, 'continue' => true ];
        $find = function(Node $inNode, array &$inOutResult) use ($inOptLimit, $inSelector) {
            if (! $inOutResult['continue']) {
                return;
            }

            if ($inSelector($inNode->getData())) {
                $inOutResult['found'][] = $inNode;
                $inOutResult['count'] += 1;
                if ($inOptLimit > 0) {
                    if ($inOutResult['count'] >= $inOptLimit) {
                        $inOutResult['continue'] = false;
                    }
                }
            }
        };

        $this->traverse($find, $result);
        return $result['found'];
    }

    /**
     * This method creates an index of all the nodes in the tree.
     * @param callable|null $inOptDataIndexBuilder Function used to generate an identifier of a given node's data.
     *        The function signature must be: `string function(mixed $inData)`.
     *          * If no function is provided, then the method uses the function set by `setDataIndexBuilder()`.
     *          * If the method `setDataIndexBuilder()` has not been called, then the identifier is generated using SHA1.
     * @param bool $inOptUnique This optional parameter indicated whether the index should refer to a unique object or not.
     *          * If the parameter's value is true, then the method assumes that the index refers to only one node.
     *            In this case, an index points to a (single) node.
     *          * If the parameter's value is false, then the method assumes that the index refers to at least, one node.
     *            In this case, an index points to an array of nodes.
     * @return array The method returns an array which keys are the identifiers, and the values are the nodes.
     *         Please note that, depending on the value of the parameter `$inOptUnique`, the array's values are (single) nodes or arrays of nodes.
     */
    public function index(callable $inOptDataIndexBuilder=null, $inOptUnique=true) {

        if (is_null($inOptDataIndexBuilder)) {
            $inOptDataIndexBuilder = $this->__dataIndexBuilder;
        }

        $index = [];
        $dataMaker = function(Node $inNode, array &$inOutResult) use ($inOptDataIndexBuilder, $inOptUnique) {
            // Add a new entry to the nodes' index.
            if ($inOptUnique) {
                $inOutResult[$inOptDataIndexBuilder($inNode->getData())] = $inNode;
            } else {
                $inOutResult[$inOptDataIndexBuilder($inNode->getData())][] = $inNode;
            }
        };
        $this->getRoot()->traverse($dataMaker, $index);
        return $index;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // EXPORTERS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Generate the DOT representation of the tree.
     * @param callable|null $inOptDataToStringConverter Function used to convert a node's data into a printable string.
     *        Function' signature must be: `string function($inData)`.
     *        Where the variable `$inData` represents the node's data.
     *          * If no function is specified, then the used function is the one previously set by calling the method `setDataToStringConverter()`.
     *          * If no function is specified, and if no function has previously been set by calling the method `setDataToStringConverter()`, then the method assumes that nodes' data are printable.
     * @return string The method returns the DOT representation of the tree.
     */
    public function toDot(callable $inOptDataToStringConverter=null) {

        if (is_null($inOptDataToStringConverter)) {
            $inOptDataToStringConverter = $this->__dataToStringConverter;
        }

        $data = [
            'nodes' => [],
            'edges' => []
        ];

        $toDot = function(Node $inNode, array &$inOutResult) use ($inOptDataToStringConverter) {
            // For every given node, we have its parent.

            $nodeId = spl_object_hash($inNode);
            $nodeLabel = $inOptDataToStringConverter($inNode->getData());
            $inOutResult['nodes'][] = '   "' . $nodeId . '" [label="' . $nodeLabel. '"];';

            if ($inNode->isRoot()) {
                return;
            }

            $parentId = spl_object_hash($inNode->getParent());
            $inOutResult['edges'][] = '   "' . $parentId . '" -> "' . $nodeId . '";';
        };

        $this->getRoot()->traverse($toDot, $data);
        $dot = ["digraph mytree {"];
        foreach ($data['nodes'] as $node) {
            array_push($dot, $node);
        }
        foreach ($data['edges'] as $edge) {
            array_push($dot, $edge);
        }
        array_push($dot, "}");
        array_push($dot, "/* Usage: dot -Tgif -Ograph graph.dot */");
        return implode("\n", $dot);
    }

    /**
     * This method returns an array that represents the tree.
     * Each node is an array `[ 'data' => ..., 'children' => [ ... ] ]`
     * For a leaf the entry "children" points to an empty array (`[]`).
     * @param callable|null $inOptDataSerializer Function used to serialize nodes' data.
     *        The signature for the function pointed by `$inOptDataSerializer` must be: `string function(mixed $inData)`.
     * @return array The method returns an array that represents the tree.
     */
    public function toArray(callable $inOptDataSerializer=null) {

        if (is_null($inOptDataSerializer)) {
            $inOptDataSerializer = function($inData) {
                return $inData;
            };
        }

        // Please, do not be confused between PHP's references and C pointers.
        //
        //      $array = [ 'a', 'b', 'c' ];
        //
        //      $ref      = &$array; // $ref is a reference to $array
        //      $copy     = $ref;    // But $copy is a copy of $array!
        //      $otherRef = &$ref;   // While $otherRef is a reference to $array.
        //
        //      $copy[] = 'd';
        //      var_dump($array); // Should be [ 'a', 'b', 'c' ]
        //
        //      $otherRef[] = 'd';
        //      var_dump($array); // Should be [ 'a', 'b', 'c', 'd' ]

        $result = [ 'index' => [], 'tree' => null ];

        $arrayMaker = function(Node $inNode, array &$inOutResult) use ($inOptDataSerializer) {

            $currentNodeId = spl_object_hash($inNode);

            $arrayNode = [
                'data' => $inOptDataSerializer($inNode->getData()),
                'children' => []
            ];

            $inOutResult['index'][$currentNodeId] = &$arrayNode;

            if ($inNode->isRoot()) {
                $inOutResult['tree'] = &$arrayNode;
                return;
            }

            $parentNode = $inNode->getParent();
            $parentNodeId = spl_object_hash($parentNode);
            $parentArrayNode = &$inOutResult['index'][$parentNodeId];
            $parentArrayNode['children'][] = &$arrayNode;
        };

        $this->getRoot()->traverse($arrayMaker, $result);
        return $result['tree'];
    }

    // -----------------------------------------------------------------------------------------------------------------
    // PROCESSORS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Walk through all nodes of the tree and, for each encountered node, execute a user provided function.
     * @param callable $inProcessor Function to execute whenever a node is encountered.
     *        Function's signature must be: `void function(Node $inNode, array &$inOutResult)`
     *          * `$inNode` is the current node.
     *          * `$inOutResult` is an array that should be used by the function to store data.
     * @param array $inOutResult Persistent context passed to the given function $inFunction.
     *        The function can use this context to store and organize data.
     */
    public function traverse(callable $inProcessor, array &$inOutResult) {
        $this->getRoot()->traverse($inProcessor, $inOutResult);
    }

    // -----------------------------------------------------------------------------------------------------------------
    // OTHERS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Walk through a tree defined as a combination of associative arrays.
     * @param array $inNode The associative array that represents the tree's root node.
     *        Each node of the tree is an associative array with the following keys:
     *          * data: arbitrary data.
     *          * children: an (non associative) array of nodes.
     * @param callable $inFunction Function to execute each time a node is encountered.
     *        The function' signature must be: `void function(array &$inCurrent, $isLeaf, &$inParent, &$inOutResult)`
     *          * `$inCurrent`: (`array`) the current node.
     *          * `$isLeaf`: (`bool`) this boolean tells the function whether the current node is a leaf or not.
     *          * `$inParent`: (`array`|`null`) associative array that represents the parent's node.
     *                           This value may be null is the current node is the root node.
     *          * `$inOutResult`: (`array`) permanent variable used by the function to organize and store values.
     * @param array $inOutResult Reference to an associative array used to store the data extracted from the tree.
     *        Please note that the result must be initialized according to the given function.
     * @param array $inOptParent This value represents the parent of the current node.
     * @throws \Exception
     */
    static public function arrayTraverse(array $inNode, callable $inFunction, array &$inOutResult, array $inOptParent=null) {

        // Sanity checks
        if (! array_key_exists('data', $inNode)) {
            throw new \Exception("This given array in not a valid tree. Key 'data' is missing!");
        }

        if (! array_key_exists('children', $inNode)) {
            throw new \Exception("This given array in not a valid tree. Key 'children' is missing!");
        }

        if (! is_array($inNode['children'])) {
            throw new \Exception("This given array in not a valid tree. Key 'children' is not an array!");
        }

        // Call the user provided function on the current node.
        $inFunction($inNode, count($inNode['children']) > 0, $inOptParent, $inOutResult);

        // Walk through the children.
        foreach ($inNode['children'] as $_child) {
            if (count($_child['children']) > 0) {
                // The actual node is not a leaf. Let's walk through the children.
                self::arrayTraverse($_child, $inFunction, $inOutResult, $inNode);
                // As long as we encounter a child, we call the method recursively. Thus method's execution's contexts pile up.
                // However, as soon as we encounter a leaf, we start to continue the execution of all previously piled up method's execution's contexts.
                // Once all piled up execution's contexts have ended, we walk through the next tree's node.
                continue;
            }
            // The current node is a leaf.
            $inFunction($_child, true, $inNode, $inOutResult);
        }
    }

}