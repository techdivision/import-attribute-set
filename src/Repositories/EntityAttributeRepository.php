<?php

/**
 * TechDivision\Import\Attribute\Set\Repositories\EntityAttributeRepository
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Repositories;

use TechDivision\Import\Attribute\Set\Utils\SqlStatementKeys;
use TechDivision\Import\Attribute\Set\Utils\MemberNames;

/**
 * Repository implementation to load EAV entity attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class EntityAttributeRepository extends \TechDivision\Import\Attribute\Repositories\EntityAttributeRepository implements EntityAttributeRepositoryInterface
{

    /**
     * The prepared statement to load an existing EAV entity attributes for the given attribute group ID.
     *
     * @var \PDOStatement
     */
    protected $entityAttributeByAttributeGroupId;

    /**
     * The prepared statement to load an existing EAV entity attributes for the given entity type ID and attribute set name.
     *
     * @var \PDOStatement
     */
    protected $entityAttributeByEntityTypeIdAndAttributeSetNameStmt;

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
        $this->entityAttributeByAttributeGroupId =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::ENTITY_ATTRIBUTES_BY_ATTRIBUTE_GROUP_ID));
        $this->entityAttributeByEntityTypeIdAndAttributeSetNameStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::ENTITY_ATTRIBUTES_BY_ENTITY_TYPE_ID_AND_ATTRIBUTE_SET_NAME));
    }

    /**
     * Returns the EAV entity attributes for the attribute group with the passed ID.
     *
     * @param integer $attributeGroupId The attribute group ID to load the EAV entity attributes for
     *
     * @return array|null The EAV attributes with for the passed attribute group ID
     */
    public function findAllByAttributeGroupId($attributeGroupId)
    {

        // load and return the EAV attribute options with the passed parameters
        $this->entityAttributeByAttributeGroupId->execute(array(MemberNames::ATTRIBUTE_GROUP_ID => $attributeGroupId));
        return $this->entityAttributeByAttributeGroupId->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Returns the EAV entity attributes for the entity type ID and attribute set with the passed name.
     *
     * @param integer $entityTypeId     The entity type ID to load the EAV entity attributes for
     * @param string  $attributeSetName The attribute set name to return the EAV entity attributes for
     *
     * @return array|null The EAV attributes with for the passed entity type ID and attribute set name
     */
    public function findAllByEntityTypeIdAndAttributeSetName($entityTypeId, $attributeSetName)
    {

        // initialize the params
        $params = array(
            MemberNames::ENTITY_TYPE_ID     => $entityTypeId,
            MemberNames::ATTRIBUTE_SET_NAME => $attributeSetName
        );

        // load and return the EAV attribute options with the passed parameters
        $this->entityAttributeByEntityTypeIdAndAttributeSetNameStmt->execute($params);
        return $this->entityAttributeByEntityTypeIdAndAttributeSetNameStmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
