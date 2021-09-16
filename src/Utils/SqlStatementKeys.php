<?php

/**
 * TechDivision\Import\Attribute\Set\Utils\SqlStatementKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Utils;

/**
 * Utility class with keys of the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class SqlStatementKeys extends \TechDivision\Import\Attribute\Utils\SqlStatementKeys
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

    /**
     * The SQL statement to load the EAV entity attributes by the attribute group ID.
     *
     * @var string
     */
    const ENTITY_ATTRIBUTES_BY_ATTRIBUTE_GROUP_ID = 'entity_attributes.by.attribute_group_id';

    /**
     * The SQL statement to load the EAV entity attributes by the entity type ID and attribute set name.
     *
     * @var string
     */
    const ENTITY_ATTRIBUTES_BY_ENTITY_TYPE_ID_AND_ATTRIBUTE_SET_NAME = 'entity_attributes.by.entity_type_id.and.attribute_set_name';

    /**
     * The SQL statement to load the EAV attribute group by the attribute set ID and attribute group code.
     *
     * @var string
     */
    const EAV_ATTRIBUTE_GROUP_BY_ATTRIBUTE_SET_ID_AND_ATTRIBUTE_GROUP_CODE = 'eav_attribute_group.by.attribute_set_id.and.attribute_group_code';
}
