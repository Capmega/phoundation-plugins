<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Widgets\Panels;

use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Mdb Plugin Panel class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class Panel extends TemplateRenderer
{
    /**
     * Panel class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Widgets\Panels\Panel $element)
    {
        parent::__construct($element);
    }
}