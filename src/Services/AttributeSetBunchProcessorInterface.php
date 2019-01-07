<?php

/**
 * TechDivision\Import\Attribute\Set\Services\AttributeSetBunchProcessorInterface
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

namespace TechDivision\Import\Attribute\Set\Services;

/**
 * Interface for a attribute bunch processor.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
interface AttributeSetBunchProcessorInterface extends AttributeSetProcessorInterface
{

    /**
     * Return's the attribute set repository instance.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeSetRepositoryInterface The attribute set repository instance
     */
    public function getEavAttributeSetRepository();

    /**
     * Return's the attribute group repository instance.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeGroupRepositoryInterface The attribute group repository instance
     */
    public function getEavAttributeGroupRepository();

    /**
     * Return's the attribute set action instance.
     *
     * @return \TechDivision\Import\Attribute\Set\Actions\EavAttributeSetActionInterface The attribute set action instance
     */
    public function getEavAttributeSetAction();

    /**
     * Return's the attribute group action instance.
     *
     * @return \TechDivision\Import\Attribute\Set\Actions\EavAttributeGroupActionInterface The attribute group action instance
     */
    public function getEavAttributeGroupAction();

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
     * @return void
     */
    public function persistAttributeGroup(array $attributeGroup, $name = null);

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
