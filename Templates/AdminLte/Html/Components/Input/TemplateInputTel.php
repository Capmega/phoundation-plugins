<?php

declare(strict_types=1);

namespace Templates\AdminLte\Html\Components\Input;


/**
 * Class TemplateInputTel
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
class TemplateInputTel extends TemplateInput
{
    /**
     * InputTel class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Input\InputTel $element)
    {
        $element->addClass( 'form-control');
        parent::__construct($element);
    }
}