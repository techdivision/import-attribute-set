<?php

/**
 * TechDivision\Import\Attribute\Set\Services\AttributeSetBunchProcessorInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Services;

/**
 * Interface for a attribute bunch processor.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
interface AttributeSetBunchProcessorInterface extends AttributeSetProcessorInterface
{

    /**
     * Return's the raw entity loader instance.
     *
     * @return \TechDivision\Import\Loaders\LoaderInterface The raw entity loader instance
     */
    public function getRawEntityLoader();

    /**
     * Return's the attribute set repository instance.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeSetRepositoryInterface The attribute set repository instance
     */
    public function getEavAttributeSetRepository();

    /**
     * Return's the attribute group repository instance.
     *
     * @return \TechDivision\Import\Attribute\Set\Repositories\EavAttributeGroupRepositoryInterface The attribute group repository instance
     */
    public function getEavAttributeGroupRepository();

    /**
     * Return's the entity attribute repository instance.
     *
     * @return \TechDivision\Import\Attribute\Set\Repositories\EntityAttributeRepositoryInterface The entity attribute repository instance
     */
    public function getEntityAttributeRepository();

    /**
     * Return's the attribute set action instance.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The attribute set action instance
     */
    public function getEavAttributeSetAction();

    /**
     * Return's the attribute group action instance.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The attribute group action instance
     */
    public function getEavAttributeGroupAction();

    /**
     * Return's the entity attribute action instance.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The entity attribute action instance
     */
    public function getEntityAttributeAction();

    /**
     * Load's and return's a raw entity without primary key but the mandatory members only and nulled values.
     *
     * @param string $entityTypeCode The entity type code to return the raw entity for
     * @param array  $data           An array with data that will be used to initialize the raw entity with
     *
     * @return array The initialized entity
     */
    public function loadRawEntity($entityTypeCode, array $data = array());

    /**
     * Load's and return's the EAV attribute set with the passed entity type code and attribute set name.
     *
     * @param string $entityTypeCode   The entity type code of the EAV attribute set to load
     * @param string $attributeSetName The attribute set name of the EAV attribute set to return
     *
     * @return array The EAV attribute set
     */
    public function loadAttributeSetByEntityTypeCodeAndAttributeSetName($entityTypeCode, $attributeSetName);

    /**
     * Load's and return's the EAV attribute set with the passed entity type ID and attribute set name.
     *
     * @param string $entityTypeId     The entity type ID of the EAV attribute set to load
     * @param string $attributeSetName The attribute set name of the EAV attribute set to return
     *
     * @return array The EAV attribute set
     */
    public function loadAttributeSetByEntityTypeIdAndAttributeSetName($entityTypeId, $attributeSetName);

    /**
     * Load's the EAV attribute group with the passed entity type code, attribute set and attribute group name.
     *
     * @param string $entityTypeCode     The entity type code of the EAV attribute group to return
     * @param string $attributeSetName   The attribute set name of the EAV attribute group to return
     * @param string $attributeGroupName The attribute group name of the EAV attribute group to return
     *
     * @return array The EAV attribute group
     */
    public function loadAttributeGroupByEntityTypeCodeAndAttributeSetNameAndAttributeGroupName($entityTypeCode, $attributeSetName, $attributeGroupName);

    /**
     * Returns the EAV entity attributes for the attribute group with the passed ID.
     *
     * @param integer $attributeGroupId The attribute group ID to load the EAV entity attributes for
     *
     * @return array|null The EAV attributes with for the passed attribute group ID
     */
    public function loadEntityAttributesByAttributeGroupId($attributeGroupId);

    /**
     * Returns the EAV entity attributes for the entity type ID and attribute set with the passed name.
     *
     * @param integer $entityTypeId     The entity type ID to load the EAV entity attributes for
     * @param string  $attributeSetName The attribute set name to return the EAV entity attributes for
     *
     * @return array|null The EAV entity attributes with for the passed entity type ID and attribute set name
     */
    public function loadEntityAttributesByEntityTypeIdAndAttributeSetName($entityTypeId, $attributeSetName);

    /**
     * Return's the EAV entity attribute with the passed attribute and attribute set ID.
     *
     * @param integer $attributeId    The ID of the EAV entity attribute's attribute to return
     * @param integer $attributeSetId The ID of the EAV entity attribute's attribute set to return
     *
     * @return array The EAV entity attribute
     */
    public function loadEntityAttributeByAttributeIdAndAttributeSetId($attributeId, $attributeSetId);

    /**
     * Return's the attribute groups for the passed attribute set ID, whereas the array
     * is prepared with the attribute group names as keys.
     *
     * @param mixed $attributeSetId The EAV attribute set ID to return the attribute groups for
     *
     * @return array|boolean The EAV attribute groups for the passed attribute ID
     */
    public function loadAttributeGroupsByAttributeSetId($attributeSetId);

    /**
     * Return's the attribute group for the passed attribute set ID and attribute group code.
     *
     * @param integer $attributeSetId     The EAV attribute set ID to return the attribute group for
     * @param string  $attributeGroupCode The EAV attribute group code to load the attribute group for
     *
     * @return array|boolean The EAV attribute group for the passed attribute set ID and attribute group code
     */
    public function loadAttributeGroupByAttributeSetIdAndAttributeGroupCode($attributeSetId, $attributeGroupCode);

    /**
     * Persist's the passed EAV attribute set data and return's the ID.
     *
     * @param array       $attributeSet The attribute set data to persist
     * @param string|null $name         The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted attribute set
     */
    public function persistAttributeSet(array $attributeSet, $name = null);

    /**
     * Persist the passed EAV attribute group.
     *
     * @param array       $attributeGroup The attribute group to persist
     * @param string|null $name           The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted attribute group
     */
    public function persistAttributeGroup(array $attributeGroup, $name = null);

    /**
     * Persist's the passed EAV entity attribute data and return's the ID.
     *
     * @param array       $entityAttribute The entity attribute data to persist
     * @param string|null $name            The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistEntityAttribute(array $entityAttribute, $name = null);

    /**
     * Delete's the EAV attribute set with the passed attributes.
     *
     * @param array       $row  The attributes of the EAV attribute group to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteAttributeSet($row, $name = null);
}
