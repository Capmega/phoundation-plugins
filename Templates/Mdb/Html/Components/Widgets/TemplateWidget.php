<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Widgets;

use Phoundation\Web\Html\Components\Widgets\Widget;
use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Class TemplateWidget
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
abstract class TemplateWidget extends TemplateRenderer
{
    /**
     * Widget class constructor
     */
    public function __construct(Widget $element)
    {
        parent::__construct($element);
    }
}