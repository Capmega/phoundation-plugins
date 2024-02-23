<?php

declare(strict_types=1);


namespace Templates\Mdb\Html\Components;

use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Mdn Plugin BreadCrumbs class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class BreadCrumbs extends TemplateRenderer
{
    /**
     * BreadCrumbs class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Widgets\BreadCrumbs $element)
    {
        parent::__construct($element);
    }
}