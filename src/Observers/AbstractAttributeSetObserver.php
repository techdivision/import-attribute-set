<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\AbstractAttributeSetObserver
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

use TechDivision\Import\Subjects\SubjectInterface;
use TechDivision\Import\Observers\AbstractObserver;
use TechDivision\Import\Attribute\Set\Services\AttributeSetBunchProcessorInterface;
use TechDivision\Import\Observers\StateDetectorInterface;

/**
 * Abstract attribute observer that handles the process to import attribute set bunches.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
abstract class AbstractAttributeSetObserver extends AbstractObserver
{

    /**
     * The attribute set bunch processor instance.
     *
     * @var \TechDivision\Import\Attribute\Set\Services\AttributeSetBunchProcessorInterface
     */
    protected $attributeSetBunchProcessor;

    /**
     * Initializes the observer with the passed subject instance.
     *
     * @param \TechDivision\Import\Attribute\Services\AttributeBunchProcessorInterface $attributeSetBunchProcessor The attribute set bunch processor instance
     * @param \TechDivision\Import\Observers\StateDetectorInterface|null               $stateDetector              The state detector instance to use
     */
    public function __construct(AttributeSetBunchProcessorInterface $attributeSetBunchProcessor, StateDetectorInterface $stateDetector = null)
    {

        // set the attribute set bunch processor instance
        $this->attributeSetBunchProcessor = $attributeSetBunchProcessor;

        // pass the state detector to the parent constructor
        parent::__construct($stateDetector);
    }

    /**
     * Return's the attribute set bunch processor instance.
     *
     * @return \TechDivision\Import\Attribute\Set\Services\AttributeSetBunchProcessorInterface The attribute set bunch processor instance
     */
    protected function getAttributeSetBunchProcessor()
    {
        return $this->attributeSetBunchProcessor;
    }

    /**
     * Will be invoked by the action on the events the listener has been registered for.
     *
     * @param \TechDivision\Import\Subjects\SubjectInterface $subject The subject instance
     *
     * @return array The modified row
     * @see \TechDivision\Import\Observers\ObserverInterface::handle()
     */
    public function handle(SubjectInterface $subject)
    {

        // initialize the row
        $this->setSubject($subject);
        $this->setRow($subject->getRow());

        // process the functionality and return the row
        $this->process();

        // return the processed row
        return $this->getRow();
    }

    /**
     * Queries whether or not the attribute set with the passed entity type code and attribute set
     * name has already been processed.
     *
     * @param string $entityTypeCode   The entity type code to check
     * @param string $attributeSetName The attribute set name to check
     *
     * @return boolean TRUE if the attribute set has been processed, else FALSE
     */
    protected function hasBeenProcessed($entityTypeCode, $attributeSetName)
    {
        return $this->getSubject()->hasBeenProcessed($entityTypeCode, $attributeSetName);
    }

    /**
     * Set's the attribute set that has been created recently.
     *
     * @param array $lastAttributeSet The attribute set
     *
     * @return void
     */
    protected function setLastAttributeSet(array $lastAttributeSet)
    {
        $this->getSubject()->setLastAttributeSet($lastAttributeSet);
    }

    /**
     * Return's the attribute set that has been created recently.
     *
     * @return array The attribute set
     */
    protected function getLastAttributeSet()
    {
        return $this->getSubject()->getLastAttributeSet();
    }

    /**
     * Process the observer's business logic.
     *
     * @return void
     */
    abstract protected function process();
}
