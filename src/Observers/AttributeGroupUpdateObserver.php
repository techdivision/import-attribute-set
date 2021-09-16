<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\AttributeGroupUpdateObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Observers;

use TechDivision\Import\Attribute\Set\Utils\MemberNames;

/**
 * Observer that add/update's the EAV attribute group itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class AttributeGroupUpdateObserver extends AttributeGroupObserver
{

    /**
     * Initialize the attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The attribute attributes
     *
     * @return array The initialized attribute
     */
    protected function initializeAttribute(array $attr)
    {

        // load the entity type code
        $entityTypeCode = $this->getEntityTypeCode();

        // load the last attribute set name
        $attributeSet = $this->getLastAttributeSet();
        $attributeSetName = $attributeSet[MemberNames::ATTRIBUTE_SET_NAME];

        // load the attribute group name
        $attributeGroupName = $attr[MemberNames::ATTRIBUTE_GROUP_NAME];

        // query whether or not an EAV attribute group with the given params already exists
        if ($entity = $this->loadAttributeGroupByEntityTypeCodeAndAttributeSetNameAndAttributeGroupName($entityTypeCode, $attributeSetName, $attributeGroupName)) {
            return $this->mergeEntity($entity, $attr);
        }

        // if not, simply return the attributes
        return $attr;
    }

    /**
     * Return's the EAV attribute group with the passed entity type code, attribute set and attribute group name.
     *
     * @param string $entityTypeCode     The entity type code of the EAV attribute group to return
     * @param string $attributeSetName   The attribute set name of the EAV attribute group to return
     * @param string $attributeGroupName The attribute group name of the EAV attribute group to return
     *
     * @return array The EAV attribute group
     */
    protected function loadAttributeGroupByEntityTypeCodeAndAttributeSetNameAndAttributeGroupName($entityTypeCode, $attributeSetName, $attributeGroupName)
    {
        return $this->getAttributeSetBunchProcessor()->loadAttributeGroupByEntityTypeCodeAndAttributeSetNameAndAttributeGroupName($entityTypeCode, $attributeSetName, $attributeGroupName);
    }
}
