<?php

declare(strict_types=1);


namespace Templates\AdminLte\Html\Layouts;

use Phoundation\Web\Html\TemplateRenderer;


/**
 * AdminLte Plugin Layout class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
abstract class Layout extends TemplateRenderer
{
    /**
     * Layout class constructor
     */
    public function __construct(\Phoundation\Web\Html\Layouts\Layout $element)
    {
        parent::__construct($element);
    }
}