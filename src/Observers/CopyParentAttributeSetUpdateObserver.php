<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\CopyParentAttributeSetUpdateObserver
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
 * Observer that copies the EAV attribute groups and attribute relations from the parent in update mode.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class CopyParentAttributeSetUpdateObserver extends CopyParentAttributeSetObserver
{

    /**
     * Initialize the attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The attribute attributes
     *
     * @return array The initialized attribute
     */
    protected function initializeAttributeForAttributeGroup(array $attr)
    {

        // load the attribute set + attribute group code
        $attributeSetId = $attr[MemberNames::ATTRIBUTE_SET_ID];
        $attributeGroupCode = $attr[MemberNames::ATTRIBUTE_GROUP_CODE];

        // load the attribute group entity
        if ($entity = $this->loadAttributeGroupByAttributeSetIdAndAttributeGroupCode($attributeSetId, $attributeGroupCode)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Initialize the attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The attribute attributes
     *
     * @return array The initialized attribute
     */
    protected function initializeAttributeForEntityAttribute(array $attr)
    {

        // load the attribute + attribute set ID from the passed attributes
        $attributeId = $attr[MemberNames::ATTRIBUTE_ID];
        $attributeSetId = $attr[MemberNames::ATTRIBUTE_SET_ID];

        // load the attribute entity attribute
        if ($entity = $this->loadEntityAttributeByAttributeIdAndAttributeSetId($attributeId, $attributeSetId)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Return's the EAV entity attribute with the passed attribute and attribute set ID.
     *
     * @param integer $attributeId    The ID of the EAV entity attribute's attribute to return
     * @param integer $attributeSetId The ID of the EAV entity attribute's attribute set to return
     *
     * @return array The EAV entity attribute
     */
    protected function loadEntityAttributeByAttributeIdAndAttributeSetId($attributeId, $attributeSetId)
    {
        return $this->getAttributeSetBunchProcessor()->loadEntityAttributeByAttributeIdAndAttributeSetId($attributeId, $attributeSetId);
    }

    /**
     * Return's the attribute group for the passed attribute set ID and attribute group code.
     *
     * @param integer $attributeSetId     The EAV attribute set ID to return the attribute group for
     * @param string  $attributeGroupCode The EAV attribute group code to load the attribute group for
     *
     * @return array|boolean The EAV attribute group for the passed attribute set ID and attribute group code
     */
    protected function loadAttributeGroupByAttributeSetIdAndAttributeGroupCode($attributeSetId, $attributeGroupCode)
    {
        return $this->getAttributeSetBunchProcessor()->loadAttributeGroupByAttributeSetIdAndAttributeGroupCode($attributeSetId, $attributeGroupCode);
    }
}
