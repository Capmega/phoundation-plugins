<?php

declare(strict_types=1);


namespace Templates\None\Html\Components;

use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * None Plugin Button class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\None
 */
class Button extends TemplateRenderer
{
    /**
     * Button class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Buttons\Button $element)
    {
        parent::__construct($element);
    }
}