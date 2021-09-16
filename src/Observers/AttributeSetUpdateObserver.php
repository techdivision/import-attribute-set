<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\AttributeSetUpdateObserver
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

use TechDivision\Import\Attribute\Utils\MemberNames;

/**
 * Observer that add/update's the EAV attribute set itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class AttributeSetUpdateObserver extends AttributeSetObserver
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

        // load the entity type ID and the attribute set name
        $entityTypeId = $attr[MemberNames::ENTITY_TYPE_ID];
        $attributeSetName = $attr[MemberNames::ATTRIBUTE_SET_NAME];

        // try to load the EAV attribute set with the entity type code and the attribute set name
        if ($entity = $this->loadAttributeSetByEntityTypeIdAndAttributeSetName($entityTypeId, $attributeSetName)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Load's and return's the EAV attribute set with the passed entity type ID and attribute set name.
     *
     * @param string $entityTypeId     The entity type ID of the EAV attribute set to load
     * @param string $attributeSetName The attribute set name of the EAV attribute set to return
     *
     * @return array The EAV attribute set
     */
    protected function loadAttributeSetByEntityTypeIdAndAttributeSetName($entityTypeId, $attributeSetName)
    {
        return $this->getAttributeSetBunchProcessor()->loadAttributeSetByEntityTypeIdAndAttributeSetName($entityTypeId, $attributeSetName);
    }
}
