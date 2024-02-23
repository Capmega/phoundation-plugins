<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputNumber;


/**
 * Class TemplateInputNumber
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplateInputNumber extends TemplateInput
{
    /**
     * InputNumeric class constructor
     */
    public function __construct(InputNumber $element)
    {
        $element->addClass('form-control');
        parent::__construct($element);
    }
}