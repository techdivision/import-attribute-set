<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\AttributeSetObserver
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
 * Observer that create's the EAV attribute set itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class AttributeSetObserver extends AbstractAttributeSetObserver
{

    /**
     * Process the observer's business logic.
     *
     * @return void
     */
    protected function process()
    {

        // load the entity type code and attribute set name
        $entityTypeCode = $this->getValue(ColumnKeys::ENTITY_TYPE_CODE);
        $attributeSetName = $this->getValue(ColumnKeys::ATTRIBUTE_SET_NAME);

        // query whether or not we've found a line with a attribute group definition
        if ($entityTypeCode === null && $attributeSetName === null) {
            return;
        }

        // query whether or not, we've found a new entity type code/attribute set name => means we've found a new attribute set
        if ($this->hasBeenProcessed($entityTypeCode, $attributeSetName)) {
            return;
        }

        // prepare the attribue set values
        $attributeSet = $this->initializeAttribute($this->prepareAttributes());

        // persist the values and set the new attribute set ID
        $attributeSet[MemberNames::ATTRIBUTE_SET_ID] = $this->persistAttributeSet($this->initializeAttribute($this->prepareAttributes()));

        // temporarily persist the attribute set for processing the attribute groups
        $this->setLastAttributeSet($attributeSet);
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        // map the entity type code to the ID
        $entityType = $this->getEntityType($this->getValue(ColumnKeys::ENTITY_TYPE_CODE));
        $entityTypeId = $entityType[MemberNames::ENTITY_TYPE_ID];

        // load the attribute set values from the column
        $sortOrder = $this->getValue(ColumnKeys::SORT_ORDER, 0);
        $attributeSetName = $this->getValue(ColumnKeys::ATTRIBUTE_SET_NAME);

        // return the prepared product
        return $this->initializeEntity(
            array(
                MemberNames::ENTITY_TYPE_ID     => $entityTypeId,
                MemberNames::ATTRIBUTE_SET_NAME => $attributeSetName,
                MemberNames::SORT_ORDER         => $sortOrder,
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
     * Return's the entity type for the passed code.
     *
     * @param string $entityTypeCode The entity type code
     *
     * @return array The requested entity type
     * @throws \Exception Is thrown, if the entity type with the passed code is not available
     */
    protected function getEntityType($entityTypeCode)
    {
        return $this->getSubject()->getEntityType($entityTypeCode);
    }

    /**
     * Persist the passed attribute set.
     *
     * @param array $attributeSet The attribute set to persist
     *
     * @return string The ID of the persisted attribute set
     */
    protected function persistAttributeSet(array $attributeSet)
    {
        return $this->getAttributeSetBunchProcessor()->persistAttributeSet($attributeSet);
    }
}
