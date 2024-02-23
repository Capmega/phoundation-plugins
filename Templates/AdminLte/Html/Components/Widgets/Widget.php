<?php

declare(strict_types=1);


namespace Templates\AdminLte\Html\Components\Widgets;

use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * AdminLte Plugin Widget class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
abstract class Widget extends TemplateRenderer
{
    /**
     * Widget class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Widgets\Widget $element)
    {
        parent::__construct($element);
    }
}