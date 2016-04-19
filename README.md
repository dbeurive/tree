# Description

This package implements various tree utilities.

# Installation

From the command line:

    composer require dbeurive/tree

From your `composer.json` file:

```json
{
    "require": {
        "dbeurive/tree": "1.0.*"
    }
}
```

# API documentation

The detailed documentation of the API can be extracted from the code by using [PhpDocumentor](https://www.phpdoc.org/).
The file `phpdoc.xml` contains the required configuration for `PhpDocumentor`.
To generate the API documentation, just move into the root directory of this package and run `PhpDocumentor` from this location.

Note:

> Since all the PHP code is documented using PhpDoc annotations, you should be able to exploit the auto completion feature from your favourite IDE.
> If you are using Eclipse, NetBeans or PhPStorm, you probably won’t need to consult the generated API documentation.

Since the API is quite simple and intuitive, the present document presents examples of code. 
These examples are located under the directory `examples`.

# Examples 

All examples are based on the tree which structure is represented by the figure below.

![Image of the tree](https://github.com/dbeurive/tree/blob/master/doc/tree.gif)

**[treeObject.php](https://github.com/dbeurive/tree/blob/master/examples/treeObject.php)**: this example shows how to create a tree using the tree builder. It creates an instance of class `\dbeurive\Tree\Tree`.

**[treeArray.php](https://github.com/dbeurive/tree/blob/master/examples/treeArray.php)**: this example illustrates the procedure to create a tree (an object of class `\dbeurive\Tree\Tree`) from an array of imbricated arrays.

**[treeObjectTraverse.php](https://github.com/dbeurive/tree/blob/master/examples/treeObjectTraverse.php)**: this example shows how to traverse a tree that is an object of class `\dbeurive\Tree\Tree`.

**[treeArrayTravserse.php](https://github.com/dbeurive/tree/blob/master/examples/treeArrayTravserse.php)**: this example shows how to traverse a tree represented by an array of imbricated arrays.

**[search.php](https://github.com/dbeurive/tree/blob/master/examples/search.php)**: this example shows how to search for a node's data within the entire tree.

**[treeObjectToArray.php](https://github.com/dbeurive/tree/blob/master/examples/treeObjectToArray.php)**: this example shows how to convert a tree defined as an object of class `\dbeurive\Tree\Tree` into the "array representation" (an array of imbricated arrays).

**[treeToDot.php](https://github.com/dbeurive/tree/blob/master/examples/treeToDot.php)**: this example shows how to produce a "GRAPHVIZ" representation of a tree.

**[treeObjectTraverseSerialize.php](https://github.com/dbeurive/tree/blob/master/examples/treeObjectTraverseSerialize.php)**: this example shows how to use objects (instead of scalars) as nodes' data. We create a tree that contains objects. Then we traverse the tree and we serialise all nodes. Please note that the tree is represented by an object of class `\dbeurive\Tree\Tree`.

**[treeArrayTravserseSerialize.php](https://github.com/dbeurive/tree/blob/master/examples/treeArrayTravserseSerialize.php)**: this example shows how to use objects (instead of scalars) as nodes' data. We create a tree that contains objects. Then we traverse the tree and we serialise all nodes. Please note that the tree is represented by an array of imbricated arrays.

**[treeIndex.php](https://github.com/dbeurive/tree/blob/master/examples/treeIndex.php)**: this example shows how to create an index that references all nodes within the tree. Indexes are generated from the nodes' data. Please note that, in this example, we assume that all nodes have a unique data value.

**[treeIndexMulti.php](https://github.com/dbeurive/tree/blob/master/examples/treeIndexMulti.php)**: this example shows how to create an index that references all nodes within the tree. Indexes are generated from the nodes' data. Please note that, in this example, we assume that multiple nodes may have the same data value.

**[treeSelect.php](https://github.com/dbeurive/tree/blob/master/examples/treeSelect.php)**: this example shows how to select nodes based on their data's values.

**[treeSearch.php](https://github.com/dbeurive/tree/blob/master/examples/treeSearch.php)**: this example shows how search for nodes with given values.

**[nodes.php](https://github.com/dbeurive/tree/blob/master/examples/nodes.php)**: this example illustrates various operations on nodes.
