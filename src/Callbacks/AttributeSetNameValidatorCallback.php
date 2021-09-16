<?php

/**
 * TechDivision\Import\Attribute\Set\Callbacks\AttributeSetNameValidatorCallback
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Callbacks;

use TechDivision\Import\Attribute\Set\Utils\ColumnKeys;
use TechDivision\Import\Callbacks\IndexedArrayValidatorCallback;

/**
 * A callback implementation that validates the attribute group names in an attribute import.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class AttributeSetNameValidatorCallback extends IndexedArrayValidatorCallback
{

    /**
     * Will be invoked by the observer it has been registered for.
     *
     * @param string|null $attributeCode  The code of the attribute that has to be validated
     * @param string|null $attributeValue The attribute value to be validated
     *
     * @return mixed The modified value
     */
    public function handle($attributeCode = null, $attributeValue = null)
    {

        // load the subject instance
        $subject = $this->getSubject();

        // query whether or not the attribute value is emtpy
        if ($this->isNullable($attributeValue)) {
            return;
        }

        // load the validations for the attribute set with the given name
        $validations = $this->getValidations($subject->getValue(ColumnKeys::ENTITY_TYPE_CODE));

        // query whether or not the value is valid
        if (in_array($attributeValue, $validations)) {
            return;
        }

        // throw an exception if the value is NOT in the array
        throw new \InvalidArgumentException(
            sprintf('Found invalid attribute set name "%s"', $attributeValue)
        );
    }
}
