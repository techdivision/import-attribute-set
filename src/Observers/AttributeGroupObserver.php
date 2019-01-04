<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\AttributeGroupObserver
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

use TechDivision\Import\Attribute\Set\Utils\ColumnKeys;
use TechDivision\Import\Attribute\Set\Utils\MemberNames;

/**
 * Observer that create's the EAV attribute group itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class AttributeGroupObserver extends AbstractAttributeSetObserver
{

    /**
     * Process the observer's business logic.
     *
     * @return void
     */
    protected function process()
    {

        // prepare the attribue set values
        $attributeSet = $this->initializeAttribute($this->prepareAttributes());

        // insert the entity and set the entity ID
        $this->setLastAttributeSetId($this->persistAttribute($attributeSet));
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        // initialize the default ID
        $defaultId = 0;

        // load the attribute set by the given attribute set name
        $attributeSet = $this->getAttributeSetByAttributeSetName($this->getValue(ColumnKeys::ATTRIBUTE_SET_NAME));

        // load the attribute set values from the column
        $sortOrder = $this->getValue(ColumnKeys::ATTRIBUTE_GROUP_SORT_ORDER, 0);
        $tabGroupCode = $this->getValue(ColumnKeys::ATTRIBUTE_GROUP_TAB_GROUP_CODE);
        $attributeGroupName = $this->getValue(ColumnKeys::ATTRIBUTE_GROUP_NAME);
        $attributeGroupCode = $this->getValue(ColumnKeys::ATTRIBUTE_GROUP_CODE);

        // return the prepared product
        return $this->initializeEntity(
            array(
                MemberNames::ATTRIBUTE_SET_ID     => $attributeSet[MemberNames::ATTRIBUTE_SET_ID],
                MemberNames::ATTRIBUTE_GROUP_NAME => $attributeGroupName,
                MemberNames::SORT_ORDER           => $sortOrder,
                MemberNames::DEFAULT_ID           => $defaultId,
                MemberNames::ATTRIBUTE_GROUP_CODE => $attributeGroupCode,
                MemberNames::TAB_GROUP_CODE       => $tabGroupCode
            )
        );
    }

    /**
     * Initialize the attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The attribute attributes
     *
     * @return array The initialized attribute
     */
    protected function initializeAttribute(array $attr)
    {
        return $attr;
    }

    /**
     * Persist the passed attribute group.
     *
     * @param array $attributeGroup The attribute group to persist
     *
     * @return void
     */
    protected function persistAttributeGroup(array $attributeGroup)
    {
        return $this->getAttributeSetBunchProcessor()->persistAttributeGroup($attributeGroup);
    }

    /**
     * Return's the attribute set with the passed attribute set name.
     *
     * @param string $attributeSetName The name of the requested attribute set
     *
     * @return array The attribute set data
     * @throws \Exception Is thrown, if the attribute set or the given entity type with the passed name is not available
     */
    protected function getAttributeSetByAttributeSetName($attributeSetName)
    {
        return $this->getSubject()->getAttributeSetByAttributeSetName($attributeSetName);
    }
}
