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
class SqlStatementRepository extends \TechDivision\Import\Repositories\SqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::CREATE_ATTRIBUTE_SET =>
            'INSERT
               INTO eav_attribute_set
                    (entity_type_id,
                     attribute_set_name,
                     sort_order)
             VALUES (:entity_type_id,
                     :attribute_set_name,
                     :sort_order)',
        SqlStatementKeys::CREATE_ATTRIBUTE_GROUP =>
            'INSERT
               INTO eav_attribute_group
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
            'UPDATE eav_attribute_set
                SET entity_type_id = :entity_type_id,
                    attribute_set_name = :attribute_set_name,
                    sort_order = :sort_order
              WHERE attribute_set_id = :attribute_set_id',
        SqlStatementKeys::UPDATE_ATTRIBUTE_GROUP =>
            'UPDATE eav_attribute_group
                SET attribute_set_id = :attribute_set_id,
                    attribute_group_name = :attribute_group_name,
                    sort_order = :sort_order,
                    default_id = :default_id,
                    attribute_group_code = :attribute_group_code,
                    tab_group_code = :tab_group_code
              WHERE attribute_group_id = :attribute_group_id',
        SqlStatementKeys::DELETE_ATTRIBUTE_SET =>
            'DELETE FROM eav_attribute_set WHERE attribute_set_id = :attribute_set_id',
        SqlStatementKeys::DELETE_ATTRIBUTE_GROUP =>
            'DELETE FROM eav_attribute_group WHERE attribute_group_id = :attribute_group_id'
    );

    /**
     * Initialize the the SQL statements.
     */
    public function __construct()
    {

        // call the parent constructor
        parent::__construct();

        // merge the class statements
        foreach ($this->statements as $key => $statement) {
            $this->preparedStatements[$key] = $statement;
        }
    }
}
