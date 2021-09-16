<?php

/**
 * TechDivision\Import\Attribute\Set\Repositories\EavAttributeGroupRepository
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Repositories;

use TechDivision\Import\Attribute\Set\Utils\SqlStatementKeys;
use TechDivision\Import\Attribute\Set\Utils\MemberNames;

/**
 * Repository implementation to load EAV attribute group data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class EavAttributeGroupRepository extends \TechDivision\Import\Repositories\EavAttributeGroupRepository implements EavAttributeGroupRepositoryInterface
{

    /**
     * The prepared statement to load an attribute group for a specific attribute set ID.
     *
     * @var \PDOStatement
     */
    protected $eavAttributeGroupByAttributeSetIdAndAttributeGroupCodeStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // invoke the parent instance
        parent::init();

        // initialize the prepared statements
        $this->eavAttributeGroupByAttributeSetIdAndAttributeGroupCodeStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::EAV_ATTRIBUTE_GROUP_BY_ATTRIBUTE_SET_ID_AND_ATTRIBUTE_GROUP_CODE));
    }

    /**
     * Return's the attribute group for the passed attribute set ID and attribute group code.
     *
     * @param integer $attributeSetId     The EAV attribute set ID to return the attribute group for
     * @param string  $attributeGroupCode The EAV attribute group code to load the attribute group for
     *
     * @return array|boolean The EAV attribute group for the passed attribute set ID and attribute group code
     */
    public function findOneByAttributeSetIdAndAttributeGroupCode($attributeSetId, $attributeGroupCode)
    {

        // initialize the params
        $params = array(
            MemberNames::ATTRIBUTE_SET_ID     => $attributeSetId,
            MemberNames::ATTRIBUTE_GROUP_CODE => $attributeGroupCode
        );

        // load the attributes for the given params
        $this->eavAttributeGroupByAttributeSetIdAndAttributeGroupCodeStmt->execute($params);
        return $this->eavAttributeGroupByAttributeSetIdAndAttributeGroupCodeStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
