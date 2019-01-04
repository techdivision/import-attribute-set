<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\AttributeSetUpdateObserver
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

namespace TechDivision\Import\Attribute\Set\Observers;

use TechDivision\Import\Attribute\Utils\MemberNames;

/**
 * Observer that add/update's the EAV attribute set itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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

        // load the entity type code and the attribute set name
        $entityTypeCode = $attr[MemberNames::ENTITY_TYPE_CODE];
        $attributeSetName = $attr[MemberNames::ATTRIBUTE_SET_NAME];

        // try to load the EAV attribute set with the entity type code and the attribute set name
        if ($entity = $this->loadAttributeSetByEntityTypeCodeAndAttributeSetName($entityTypeCode, $attributeSetName)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Load's and return's the EAV attribute set with the passed entity type code and attribute set name.
     *
     * @param string $entityTypeCode   The entity type code of the EAV attribute set to load
     * @param string $attributeSetName The attribute set name of the EAV attribute set to return
     *
     * @return array The EAV attribute set
     */
    protected function loadAttributeSetByEntityTypeCodeAndAttributeSetName($entityTypeCode, $attributeSetName)
    {
        return $this->getAttributeSetBunchProcessor()->loadAttributeSetByEntityTypeCodeAndAttributeSetName($entityTypeCode, $attributeSetName);
    }
}
