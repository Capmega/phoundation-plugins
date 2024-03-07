<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputSelect;


/**
 * Class TemplateSelect
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplateInputSelect extends TemplateInput
{
    /**
     * Select class constructor
     */
    public function __construct(InputSelect $element)
    {
        $element->addClass('col-sm-' . $element->getDefinition()->getSize());
        $element->addClass('form-control');
        $element->getAttributes()->add('', 'data-mdb-select-init');
        parent::__construct($element);
    }
}
