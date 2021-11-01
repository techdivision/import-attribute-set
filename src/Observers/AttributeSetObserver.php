<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\AttributeSetObserver
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

use TechDivision\Import\Dbal\Utils\EntityStatus;
use TechDivision\Import\Utils\BackendTypeKeys;
use TechDivision\Import\Observers\StateDetectorInterface;
use TechDivision\Import\Observers\AttributeLoaderInterface;
use TechDivision\Import\Observers\DynamicAttributeObserverInterface;
use TechDivision\Import\Observers\EntityMergers\EntityMergerInterface;
use TechDivision\Import\Attribute\Set\Utils\ColumnKeys;
use TechDivision\Import\Attribute\Set\Utils\MemberNames;
use TechDivision\Import\Attribute\Set\Utils\EntityTypeCodes;
use TechDivision\Import\Attribute\Set\Services\AttributeSetBunchProcessorInterface;

/**
 * Observer that create's the EAV attribute set itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class AttributeSetObserver extends AbstractAttributeSetObserver implements DynamicAttributeObserverInterface
{

    /**
     * The attribute loader instance.
     *
     * @var \TechDivision\Import\Observers\AttributeLoaderInterface
     */
    protected $attributeLoader;

    /**
     * The entity merger instance.
     *
     * @var \TechDivision\Import\Observers\EntityMergers\EntityMergerInterface
     */
    protected $entityMerger;

    /**
     * Initialize the dedicated column.
     *
     * @var array
     */
    protected $columns = array(MemberNames::SORT_ORDER => array(ColumnKeys::SORT_ORDER, BackendTypeKeys::BACKEND_TYPE_INT));

    /**
     * Initializes the observer with the passed subject instance.
     *
     * @param \TechDivision\Import\Attribute\Set\Services\AttributeSetBunchProcessorInterface $attributeSetBunchProcessor The attribute set bunch processor instance
     * @param \TechDivision\Import\Observers\AttributeLoaderInterface|null                    $attributeLoader            The attribute loader instance
     * @param \TechDivision\Import\Observers\EntityMergers\EntityMergerInterface|null         $entityMerger               The entity merger instance
     * @param \TechDivision\Import\Observers\StateDetectorInterface|null                      $stateDetector              The state detector instance to use
     */
    public function __construct(
        AttributeSetBunchProcessorInterface $attributeSetBunchProcessor,
        AttributeLoaderInterface $attributeLoader = null,
        EntityMergerInterface $entityMerger = null,
        StateDetectorInterface $stateDetector = null
    ) {

        // set the attribute loader
        $this->attributeLoader = $attributeLoader;
        $this->entityMerger = $entityMerger;

        // pass the processor to th eparend constructor
        parent::__construct($attributeSetBunchProcessor, $stateDetector);
    }

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
        $attributeSet[MemberNames::ATTRIBUTE_SET_ID] = $this->persistAttributeSet($this->initializeAttribute($this->prepareDynamicAttributes()));

        // temporarily persist the attribute set for processing the attribute groups
        $this->setLastAttributeSet($attributeSet);
    }

    /**
     * Merge's and return's the entity with the passed attributes and set's the
     * passed status.
     *
     * @param array       $entity        The entity to merge the attributes into
     * @param array       $attr          The attributes to be merged
     * @param string|null $changeSetName The change set name to use
     *
     * @return array The merged entity
     * @todo https://github.com/techdivision/import/issues/179
     */
    protected function mergeEntity(array $entity, array $attr, $changeSetName = null)
    {
        return array_merge(
            $entity,
            $this->entityMerger ? $this->entityMerger->merge($this, $entity, $attr) : $attr,
            array(EntityStatus::MEMBER_NAME => $this->detectState($entity, $attr, $changeSetName))
        );
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

        // map the entity type code to the ID
        $entityType = $this->getEntityType($this->getValue(ColumnKeys::ENTITY_TYPE_CODE));
        $entityTypeId = $entityType[MemberNames::ENTITY_TYPE_ID];

        // load the attribute set names from the column
        $attributeSetName = $this->getValue(ColumnKeys::ATTRIBUTE_SET_NAME);

        // return the prepared product
        return $this->initializeEntity(
            $this->loadRawEntity(
                array(
                    MemberNames::ENTITY_TYPE_ID     => $entityTypeId,
                    MemberNames::ATTRIBUTE_SET_NAME => $attributeSetName
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
        return $this->getAttributeSetBunchProcessor()->loadRawEntity(EntityTypeCodes::EAV_ATTRIBUTE_SET, $data);
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
