<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Panels;

use Phoundation\Web\Html\TemplateRenderer;


/**
 * Class TemplatePanel
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplatePanel extends TemplateRenderer
{
    /**
     * Panel class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Panels\Panel $element)
    {
        parent::__construct($element);
    }
}