<?php

namespace Fwolf\Config\Exception;

use Exception;

/**
 * Exception for assign non-leaf value to leaf node
 *
 * Eg:
 * - Assign single value like '42' to key 'foo'
 * - Then assign any value to key 'foo.bar'
 *
 * The first assign make key 'foo' a leaf node, it should not have any child
 * node, which second assign will make it happen.
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ReachLeafNode extends Exception
{
}
