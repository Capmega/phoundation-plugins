<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Forms;

use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Class DataEntryForm
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class DataEntryForm extends TemplateRenderer
{
    /**
     * FilterForm class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Forms\DataEntryForm $element)
    {
        parent::__construct($element);
    }
}