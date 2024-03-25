<?php

declare(strict_types=1);

namespace Templates\AdminLte\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputUrl;

/**
 * Class TemplateInputUrl
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
class TemplateInputUrl extends TemplateInput
{
    /**
     * InputUrl class constructor
     */
    public function __construct(InputUrl $component)
    {
        $component->addClass('form-control');
        parent::__construct($component);
    }
}