<?php

/**
 * TechDivision\Import\Attribute\Set\Utils\SqlStatementKeys
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Utils;

/**
 * Utility class with keys of the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class SqlStatementKeys extends \TechDivision\Import\Utils\SqlStatementKeys
{

    /**
     * The SQL statement to create a new EAV attribute set.
     *
     * @var string
     */
    const CREATE_ATTRIBUTE_SET = 'create.attribute_set';

    /**
     * The SQL statement to update an existing EAV attribute set.
     *
     * @var string
     */
    const UPDATE_ATTRIBUTE_SET = 'update.attribute_set';

    /**
     * The SQL statement to remove a existing EAV attribute set.
     *
     * @var string
     */
    const DELETE_ATTRIBUTE_SET = 'delete.attribute_set';

    /**
     * The SQL statement to create a new EAV attribute group.
     *
     * @var string
     */
    const CREATE_ATTRIBUTE_GROUP = 'create.attribute_group';

    /**
     * The SQL statement to update an existing EAV attribute group.
     *
     * @var string
     */
    const UPDATE_ATTRIBUTE_GROUP = 'update.attribute_group';

    /**
     * The SQL statement to remove a existing EAV attribute group.
     *
     * @var string
     */
    const DELETE_ATTRIBUTE_GROUP = 'delete.attribute_group';
}
