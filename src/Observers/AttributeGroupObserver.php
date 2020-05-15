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

use TechDivision\Import\Utils\BackendTypeKeys;
use TechDivision\Import\Observers\AttributeLoaderInterface;
use TechDivision\Import\Observers\DynamicAttributeObserverInterface;
use TechDivision\Import\Attribute\Set\Utils\ColumnKeys;
use TechDivision\Import\Attribute\Set\Utils\MemberNames;
use TechDivision\Import\Attribute\Set\Utils\EntityTypeCodes;
use TechDivision\Import\Attribute\Set\Services\AttributeSetBunchProcessorInterface;

/**
 * Observer that create's the EAV attribute group itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class AttributeGroupObserver extends AbstractAttributeSetObserver implements DynamicAttributeObserverInterface
{

    /**
     * The attribute loader instance.
     *
     * @var \TechDivision\Import\Observers\AttributeLoaderInterface
     */
    protected $attributeLoader;

    /**
     * Initialize the dedicated column.
     *
     * @var array
     */
    protected $columns = array(MemberNames::SORT_ORDER => array(ColumnKeys::ATTRIBUTE_GROUP_SORT_ORDER, BackendTypeKeys::BACKEND_TYPE_INT));

    /**
     * Initializes the observer with the passed subject instance.
     *
     * @param \TechDivision\Import\Attribute\Set\Services\AttributeSetBunchProcessorInterface $attributeSetBunchProcessor The attribute set bunch processor instance
     * @param \TechDivision\Import\Observers\AttributeLoaderInterface                         $attributeLoader            The attribute loader instance
     */
    public function __construct(
        AttributeSetBunchProcessorInterface $attributeSetBunchProcessor,
        AttributeLoaderInterface $attributeLoader = null
    ) {

        // set the attribute loader
        $this->attributeLoader = $attributeLoader;

        // pass the processor to th eparend constructor
        parent::__construct($attributeSetBunchProcessor);
    }

    /**
     * Process the observer's business logic.
     *
     * @return void
     */
    protected function process()
    {

        // query whether or not at least attribute group name & code has been set
        if ($this->hasValue(ColumnKeys::ATTRIBUTE_GROUP_NAME) &&
            $this->hasValue(ColumnKeys::ATTRIBUTE_GROUP_CODE)
        ) {
            // prepare the attribue set values
            $attributeSetGroup = $this->initializeAttribute($this->prepareAttributes());
            // persist the entity
            $this->persistAttributeGroup($attributeSetGroup);
        }
    }

    /**
     * Appends the dynamic to the static attributes for the EAV attribute
     * and returns them.
     *
     * @return array The array with all available attributes
     */
    protected function prepareDynamicAttributes()
    {
        return array_merge($this->prepareAttributes(), $this->attributeLoader ? $this->attributeLoader->load($this, $this->columns) : array());
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        // load the last attribute set
        $attributeSet = $this->getLastAttributeSet();

        // load the attribute set values from the column
        $defaultId = $this->getValue(ColumnKeys::DEFAULT_ID, 0);
        $tabGroupCode = $this->getValue(ColumnKeys::ATTRIBUTE_GROUP_TAB_GROUP_CODE, 'basic');
        $attributeGroupName = $this->getValue(ColumnKeys::ATTRIBUTE_GROUP_NAME);
        $attributeGroupCode = $this->getValue(ColumnKeys::ATTRIBUTE_GROUP_CODE);

        // return the prepared product
        return $this->initializeEntity(
            $this->loadRawEntity(
                array(
                    MemberNames::ATTRIBUTE_SET_ID     => $attributeSet[MemberNames::ATTRIBUTE_SET_ID],
                    MemberNames::ATTRIBUTE_GROUP_NAME => $attributeGroupName,
                    MemberNames::DEFAULT_ID           => $defaultId,
                    MemberNames::ATTRIBUTE_GROUP_CODE => $attributeGroupCode,
                    MemberNames::TAB_GROUP_CODE       => $tabGroupCode
                )
            )
        );
    }

    /**
     * Load's and return's a raw customer entity without primary key but the mandatory members only and nulled values.
     *
     * @param array $data An array with data that will be used to initialize the raw entity with
     *
     * @return array The initialized entity
     */
    protected function loadRawEntity(array $data = array())
    {
        return $this->getAttributeSetBunchProcessor()->loadRawEntity(EntityTypeCodes::EAV_ATTRIBUTE_GROUP, $data);
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
     * Return's the entity type code to be used.
     *
     * @return string The entity type code to be used
     */
    protected function getEntityTypeCode()
    {
        return $this->getSubject()->getEntityTypeCode();
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
}
