<?php

declare(strict_types=1);


namespace Templates\None\Html\Components\Input;

use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Class InputPassword
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\None
 */
class InputPassword extends TemplateRenderer
{
    /**
     * InputPassword class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Input\InputPassword $element)
    {
        $element->addClass( 'form-control');
        parent::__construct($element);
    }
}