<?php

/**
 * TechDivision\Import\Attribute\Set\Repositories\SqlStatementKeys
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

namespace TechDivision\Import\Attribute\Set\Repositories;

use TechDivision\Import\Attribute\Set\Utils\SqlStatementKeys;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class SqlStatementRepository extends \TechDivision\Import\Attribute\Repositories\SqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::CREATE_ATTRIBUTE_SET =>
            'INSERT
               INTO ${table:eav_attribute_set}
                    (entity_type_id,
                     attribute_set_name,
                     sort_order)
             VALUES (:entity_type_id,
                     :attribute_set_name,
                     :sort_order)',
        SqlStatementKeys::CREATE_ATTRIBUTE_GROUP =>
            'INSERT
               INTO ${table:eav_attribute_group}
                    (attribute_set_id,
                     attribute_group_name,
                     sort_order,
                     default_id,
                     attribute_group_code,
                     tab_group_code)
             VALUES (:attribute_set_id,
                     :attribute_group_name,
                     :sort_order,
                     :default_id,
                     :attribute_group_code,
                     :tab_group_code)',
        SqlStatementKeys::UPDATE_ATTRIBUTE_SET =>
            'UPDATE ${table:eav_attribute_set}
                SET entity_type_id = :entity_type_id,
                    attribute_set_name = :attribute_set_name,
                    sort_order = :sort_order
              WHERE attribute_set_id = :attribute_set_id',
        SqlStatementKeys::UPDATE_ATTRIBUTE_GROUP =>
            'UPDATE ${table:eav_attribute_group}
                SET attribute_set_id = :attribute_set_id,
                    attribute_group_name = :attribute_group_name,
                    sort_order = :sort_order,
                    default_id = :default_id,
                    attribute_group_code = :attribute_group_code,
                    tab_group_code = :tab_group_code
              WHERE attribute_group_id = :attribute_group_id',
        SqlStatementKeys::DELETE_ATTRIBUTE_SET =>
            'DELETE FROM ${table:eav_attribute_set} WHERE attribute_set_id = :attribute_set_id',
        SqlStatementKeys::DELETE_ATTRIBUTE_GROUP =>
            'DELETE FROM ${table:eav_attribute_group} WHERE attribute_group_id = :attribute_group_id',
        SqlStatementKeys::ENTITY_ATTRIBUTES_BY_ATTRIBUTE_GROUP_ID =>
            'SELECT *
               FROM ${table:eav_entity_attribute}
              WHERE attribute_group_id = :attribute_group_id',
        SqlStatementKeys::ENTITY_ATTRIBUTES_BY_ENTITY_TYPE_ID_AND_ATTRIBUTE_SET_NAME =>
            'SELECT t0.*
               FROM ${table:eav_entity_attribute} t0
         INNER JOIN ${table:eav_attribute_set} t1
                 ON t1.attribute_set_name = :attribute_set_name
	            AND t1.entity_type_id = :entity_type_id
                AND t0.attribute_set_id = t1.attribute_set_id',
        SqlStatementKeys::EAV_ATTRIBUTE_GROUP_BY_ATTRIBUTE_SET_ID_AND_ATTRIBUTE_GROUP_CODE =>
            'SELECT *
               FROM ${table:eav_attribute_group}
              WHERE attribute_set_id = :attribute_set_id
                AND attribute_group_code = :attribute_group_code'
    );

    /**
     * Initializes the SQL statement repository with the primary key and table prefix utility.
     *
     * @param \IteratorAggregate<\TechDivision\Import\Utils\SqlCompilerInterface> $compilers The array with the compiler instances
     */
    public function __construct(\IteratorAggregate $compilers)
    {

        // pass primary key + table prefix utility to parent instance
        parent::__construct($compilers);

        // compile the SQL statements
        $this->compile($this->statements);
    }
}
