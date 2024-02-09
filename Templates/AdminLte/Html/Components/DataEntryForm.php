<?php

declare(strict_types=1);

namespace Templates\AdminLte\Html\Components;

use PDOStatement;
use Phoundation\Core\Libraries\Library;
use Phoundation\Data\DataEntry\Definitions\Interfaces\DefinitionInterface;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Utils\Arrays;
use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Input\InputHidden;
use Phoundation\Web\Html\Components\Input\InputMultiButtonText;
use Phoundation\Web\Html\Components\Input\InputSelect;
use Phoundation\Web\Html\Components\Input\InputTextArea;
use Phoundation\Web\Html\Components\Interfaces\DataEntryFormInterface;
use Phoundation\Web\Html\Components\Interfaces\ElementInterface;
use Phoundation\Web\Html\Components\Interfaces\ElementsBlockInterface;
use Phoundation\Web\Html\Components\Tooltips\Tooltip;
use Phoundation\Web\Html\Enums\EnumDisplayMode;
use Phoundation\Web\Html\Enums\EnumInputElement;
use Phoundation\Web\Html\Enums\EnumInputType;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Renderer;
use Stringable;
use Templates\AdminLte\Html\Components\Interfaces\DataEntryFormRowsInterface;


/**
 * Class DataEntryForm
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
class DataEntryForm extends Renderer
{
    /**
     * Counter for list forms
     *
     * @var int $list_count
     */
    protected static int $list_count = 0;

    /**
     * The DataEntryForm rows renderer
     *
     * @var DataEntryFormRowsInterface $rows
     */
    protected DataEntryFormRowsInterface $rows;


    /**
     * DataEntryForm class constructor
     *
     * @param DataEntryFormInterface $render_object
     */
    public function __construct(DataEntryFormInterface $render_object)
    {
        parent::__construct($render_object);
        $this->rows = new DataEntryFormRows($render_object);
    }


    /**
     * Standard DataEntryForm object does not render any HTML, this requires a Template class
     *
     * @todo Refactor this method as it has become a godunholy mess. Also, contains lots of non template functionality
     * @return string|null
     */
    public function render(): ?string
    {
        $render_object = $this->render_object;

        if (!$render_object->getDefinitions()) {
            throw new OutOfBoundsException(tr('Cannot render DataEntryForm, no field definitions specified'));
        }

        $source        = $render_object->getSource();
        $definitions   = $render_object->getDefinitions();
        $prefix        = $render_object->getDefinitions()->getPrefix();
        $auto_focus_id = $render_object->getAutofocusId();

        if ($prefix) {
            if (str_ends_with((string) $prefix, '[]')) {
                // This is an array prefix with the closing tag attached, just remove the closing tag
                $prefix = substr($prefix, 0, -1);
            }

            if (str_contains($prefix, '[]')) {
                // This prefix contains a [] to indicate a list item. Specify correct ID's
                $prefix = str_replace('[]', '[' . static::$list_count . ']', $prefix);
            }
        }

        $is_array = str_ends_with((string) $prefix, '[');

        /*
         * $data field keys: (Or just use Definitions class)
         *
         * FIELD          DATATYPE           DEFAULT VALUE  DESCRIPTION
         * value          mixed              null           The value for this entry
         * visible        boolean            true           If false, this key will not be shown on web, and be readonly
         * virtual        boolean            false          If true, this key will be visible and can be modified but it
         *                                                  won't exist in database. It instead will be used to generate
         *                                                  a different field
         * element        string|null        "input"        Type of element, input, select, or text or callable function
         * type           string|null        "text"         Type of input element, if element is "input"
         * readonly       boolean            false          If true, will make the input element readonly
         * disabled       boolean            false          If true, the field will be displayed as disabled
         * label          string|null        null           If specified, will show a description label in HTML
         * size           int [1-12]         12             The HTML boilerplate column size, 1 - 12 (12 being the whole
         *                                                  row)
         * source         array|string|null  null           Array or query source to get contents for select, or single
         *                                                  value for text inputs
         * execute        array|null         null           Bound execution variables if specified "source" is a query
         *                                                  string
         * complete       array|bool|null    null           If defined must be bool or contain array with key "noword"
         *                                                  and "word". each key must contain a callable function that
         *                                                  returns an array with possible words for shell auto
         *                                                  completion. If bool, the system will generate this array
         *                                                  automatically from the rows for this field
         * cli            string|null        null           If set, defines the alternative column name definitions for
         *                                                  use with CLI. For example, the column may be name, whilst
         *                                                  the cli column name may be "-n,--name"
         * optional       boolean            false          If true, the field is optional and may be left empty
         * title          string|null        null           The title attribute which may be used for tooltips
         * placeholder    string|null        null           The placeholder attribute which typically shows an example
         * maxlength      string|null        null           The maxlength attribute which typically shows an example
         * pattern        string|null        null           The pattern the value content should match in browser client
         * min            string|null        null           The minimum amount for numeric inputs
         * max            string|null        null           The maximum amount for numeric inputs
         * step           string|null        null           The up / down step for numeric inputs
         * default        mixed              null           If "value" for entry is null, then default will be used
         * null_disabled  boolean            false          If "value" for entry is null, then use this for "disabled"
         * null_readonly  boolean            false          If "value" for entry is null, then use this for "readonly"
         * null_type      boolean            false          If "value" for entry is null, then use this for "type"
         */

        // If form key definitions are available, reorder the keys as in the form key definitions

        // Go over each key and add it to the form
        foreach ($definitions as $field => $definition) {
            // Add field name prefix
            $field_name = $prefix . $field;

            if ($field_name === $auto_focus_id) {
                // This field has autofocus
                $definition->setAutoFocus(true);
            }

            if ($is_array) {
                // The field name prefix is an HTML form array prefix, close that array
                $field_name .= ']';
            }

            if (!is_object($definition) or !($definition instanceof DefinitionInterface)) {
                throw new OutOfBoundsException(tr('Data key definition for field ":field / :field_name" is invalid. Iit should be an array or Definition type  but contains ":data"', [
                    ':field'      => $field,
                    ':field_name' => $field_name,
                    ':data'       => gettype($definition) . ': ' . $definition
                ]));
            }

            if ($definition->isMeta()) {
                // This is an immutable meta field, virtual field, or readonly field.
                // In creation mode we're not even going to show this, in edit mode don't put a field name because
                // users aren't even supposed to be able to submit this
                if (empty($source['id'])) {
                    continue;
                }

                if (!$definitions->getMetaVisible()) {
                    continue;
                }

                $field_name = '';
            }

            if (!$definition->getVisible()) {
                // This element shouldn't be shown, continue
                continue;
            }

            if ($definition->getDisabled() or $definition->getReadonly()) {
                // This is an unmutable field. Don't add a field names as users aren't supposed to submit this.
                $field_name = '';
            }

            // Either the component or the entire form being readonly or disabled will make the component the same
            $definition->setReadonly($definition->getReadonly() or $render_object->getReadonly());
            $definition->setDisabled($definition->getDisabled() or $render_object->getDisabled());

            // Ensure password is never sent in the form
            switch ($field) {
                case 'password':
                    $source[$field] = '';
            }

            // Hidden objects have size 0
            if ($definition->getHidden()) {
                $definition->setSize(0);
            }

            $execute = $definition->getExecute();

            if (is_string($execute)) {
                // Build the source execute array from the specified column
                $items   = explode(',', $execute);
                $execute = [];

                foreach ($items as $item) {
                    $execute[':' . $item] = isset_get($source[$item]);
                }
            }

            // Select default element
            if (!$definition->getElement()) {
                if ($definition->getSource()) {
                    // Default element for form items with a source is "select"
                    // TODO CHECK THIS! WHAT IF SOURCE IS A SINGLE STRING?
                    $definition->setElement(EnumInputElement::select);
                } else {
                    // Default element for form items "text input"
                    $definition->setElement(EnumInputElement::input);
                }
            }

            if ($definition->getDisplayCallback()) {
                // Execute the specified callback on the data before displaying it
                $source[$field] = $definition->getDisplayCallback()(isset_get($source[$field]), $source);
            }

            // Set default value and override key entry values if value is null
            if (isset_get($source[$field]) === null) {
                if ($definition->getNullElement()) {
                    $definition->setElement($definition->getNullElement());
                }

                if ($definition->getNullInputType()) {
                    $definition->setInputType($definition->getNullInputType());
                }

                if ($definition->getNullDisabled()) {
                    $definition->setDisabled($definition->getNullDisabled());
                }

                if ($definition->getNullReadonly()) {
                    $definition->setReadonly($definition->getNullReadonly());
                }

                $source[$field] = $definition->getDefault();
            }

            // Set value to value specified in $data
            if ($definition->getValue()) {
                $source[$field] = $definition->getValue();

                // Apply variables
                foreach ($source as $source_key => $source_value) {
                    if ($definitions->keyExists($source_key)) {
                        $source[$field] = str_replace(':' . $source_key, (string) $source_value, $source[$field]);
                    }
                }
            }

            // Build the form elements
            if (!$definition->getContent()) {
                switch ($definition->getElement()) {
                    case 'input':
                        if (!$definition->getInputType()) {
                            throw new OutOfBoundsException(tr('No input type specified for field ":field / :field_name"', [
                                ':field_name' => $field_name,
                                ':field'      => $field
                            ]));
                        }

                        // If we have a source query specified, then get the actual value from the query
                        if ($definition->getSource()) {
                            if (!is_array($definition->getSource())) {
                                if (!is_string($definition->getSource())) {
                                    if ($definition->getSource() instanceof Stringable) {
                                        // This is a Stringable object
                                        $definition->setSource((string) $definition->getSource());

                                    } else {
                                        // Only posibility left is instanceof PDOStatement
                                        $definition->setSource(sql()->getColumn($definition->getSource(), $execute));
                                    }
                                }
                            }
                        }

                        // Build the element class path and load the required class file
                        $type = match ($definition->getInputType()) {
                            'datetime-local' => 'DateTimeLocal',
                            'auto-suggest'   => 'AutoSuggest',
                            default          => Strings::capitalize($definition->getInputType()->value),
                        };

                        // Get the class for this element and ensure the library file is loaded
                        $element_class = Library::loadClassFile('\\Phoundation\\Web\\Html\\Components\\Input\\Input' . $type);

                        // Depending on input type we might need different code
                        switch ($definition->getInputType()) {
                            case EnumInputType::checkbox:
                                // Render the HTML for this element
                                $component = $element_class::new()
                                    ->setDefinition($definition)
                                    ->setHidden($definition->getHidden())
                                    ->setRequired($definition->getRequired())
                                    ->setValue('1')
                                    ->setChecked((bool) $source[$field]);
                                break;

                            case 'number':
                                // Render the HTML for this element
                                $component = $element_class::new()
                                    ->setDefinition($definition)
                                    ->setHidden($definition->getHidden())
                                    ->setRequired($definition->getRequired())
                                    ->setMin($definition->getMin())
                                    ->setMax($definition->getMax())
                                    ->setStep($definition->getStep())
                                    ->setValue($source[$field]);
                                break;

                            case 'date':
                                // Render the HTML for this element
                                $component = $element_class::new()
                                    ->setDefinition($definition)
                                    ->setHidden($definition->getHidden())
                                    ->setRequired($definition->getRequired())
                                    ->setMin($definition->getMin())
                                    ->setMax($definition->getMax())
                                    ->setValue($source[$field]);
                                break;

                            case 'auto-suggest':
                                // Render the HTML for this element
                                $component = $element_class::new()
                                    ->setDefinition($definition)
                                    ->setHidden($definition->getHidden())
                                    ->setRequired($definition->getRequired())
                                    ->setAutoComplete(false)
                                    ->setMinLength($definition->getMinLength())
                                    ->setMaxLength($definition->getMaxLength())
                                    ->setSourceUrl($definition->getSource())
                                    ->setVariables($definition->getVariables())
                                    ->setValue($source[$field]);
                                break;

                            case 'button':
                                // no break
                            case 'submit':
                                // Render the HTML for this element
                                $component = $element_class::new()
                                    ->setDefinition($definition)
                                    ->setHidden($definition->getHidden())
                                    ->setValue($source[$field]);
                                break;

                            case 'select':
                                // Render the HTML for this element
                                $component = $element_class::new()
                                    ->setDefinition($definition)
                                    ->setHidden($definition->getHidden())
                                    ->setRequired($definition->getRequired())
                                    ->setValue($source[$field]);
                                break;

                            default:
                                // Render the HTML for this element
                                $component = $element_class::new()
                                    ->setDefinition($definition)
                                    ->setHidden($definition->getHidden())
                                    ->setRequired($definition->getRequired())
                                    ->setMinLength($definition->getMinLength())
                                    ->setMaxLength($definition->getMaxLength())
                                    ->setAutoComplete($definition->getAutoComplete())
                                    ->setAutoSubmit($definition->getAutoSubmit())
                                    ->setValue($source[$field]);
                        }

                        $this->rows->add($definition, $component);
                        break;

                    case 'text':
                        // no-break
                    case 'textarea':
                        // If we have a source query specified, then get the actual value from the query
                        if ($definition->getSource()) {
                            $source[$field] = sql()->getColumn($definition->getSource(), $execute);
                        }

                        // Get the class for this element and ensure the library file is loaded
                        $element_class = Library::loadClassFile('\\Phoundation\\Web\\Html\\Components\\Input\\InputTextArea');
                        $component     = $element_class::new()
                            ->setDefinition($definition)
                            ->setAutoComplete($definition->getAutoComplete())
                            ->setAutoSubmit($definition->getAutoSubmit())
                            ->setHidden($definition->getHidden())
                            ->setMaxLength($definition->getMaxLength())
                            ->setRows($definition->getRows())
                            ->setContent(isset_get($source[$field]));

                        $this->rows->add($definition, $component);
                        break;

                    case 'div':
                        // no break;
                    case 'span':
                        $element_class = Strings::capitalize($definition->getElement());

                        // If we have a source query specified, then get the actual value from the query
                        if ($definition->getSource()) {
                            $source[$field] = sql()->getColumn($definition->getSource(), $execute);
                        }

                        // Get the class for this element and ensure the library file is loaded
                        $element_class = Library::loadClassFile('\\Phoundation\\Web\\Http\\Html\\Components\\' . $element_class);
                        $component     = $element_class::new()
                            ->setDefinition($definition)
                            ->setContent(isset_get($source[$field]));

                        $this->rows->add($definition, $component);
                        break;

                    case 'select':
                        // Get the class for this element and ensure the library file is loaded
                        $element_class = Library::loadClassFile('\\Phoundation\\Web\\Html\\Components\\Input\\InputSelect');
                        $component     = $element_class::new()
                            ->setDefinition($definition)
                            ->setSource($definition->getSource(), $execute)
                            ->setDisabled((bool) ($definition->getDisabled() or $definition->getReadonly()))
                            ->setReadOnly((bool) $definition->getReadonly())
                            ->setHidden($definition->getHidden())
                            ->setName($field_name)
                            ->setAutoComplete($definition->getAutoComplete())
                            ->setAutoSubmit($definition->getAutoSubmit())
                            ->setSelected(isset_get($source[$field]))
                            ->setAutoFocus($definition->getAutoFocus());

                        $this->rows->add($definition, $component);
                        break;

                    case 'inputmultibuttontext':
                        // Get the class for this element and ensure the library file is loaded
                        $element_class = Library::loadClassFile('\\Phoundation\\Web\\Html\\Components\\Input\\InputMultiButtonText');
                        $input         = $element_class::new()->setSource($definition->getSource());

                        $input->getButton()
                            ->setMode(EnumDisplayMode::from($definition->getMode()))
                            ->setContent($definition->getLabel());

                        $component = $input->getInput()
                            ->setDefinition($definition)
                            ->setHidden($definition->getHidden())
                            ->setName($field_name)
                            ->setValue($source[$field])
                            ->setContent(isset_get($source[$field]))
                            ->setAutoFocus($definition->getAutoFocus());

                        $this->rows->add($definition, $component);
                        break;

                    case '':
                        throw new OutOfBoundsException(tr('No element specified for key ":key"', [
                            ':key' => $field
                        ]));

                    default:
                        if (!is_callable($definition->getElement())) {
                            if (!$definition->getElement()) {
                                throw new OutOfBoundsException(tr('No element specified for key ":key"', [
                                    ':key' => $field
                                ]));
                            }

                            throw new OutOfBoundsException(tr('Unknown element ":element" specified for key ":key"', [
                                ':element' => $definition->getElement(),
                                ':key'     => $field
                            ]));
                        }

                        // Execute this to get the element
                        $this->rows->add($definition, $definition->getElement()($field, $definition, $source));
                }

            } elseif(is_callable($definition->getContent())) {
                if ($definition->getHidden()) {
                    $this->rows->add($definition, InputHidden::new()
                        ->setName($field)
                        ->setValue(Strings::force($source[$field], ' - '))
                        ->render());


                } else {
                    $this->rows->add($definition, $definition->getContent()($definition, $field, $field_name, $source));
                }

            } else {
                $this->rows->add($definition, $definition->getContent());
            }
        }

        // Add one empty element to (if required) close any rows
        $this->render = $this->rows->add()->render();
        static::$list_count++;
        return parent::render();
    }
}
