<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Icons;

use Phoundation\Web\Html\Components\Icons\Icon;
use Phoundation\Web\Html\Components\Icons\Icons;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Class TemplateIcons
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplateIcon extends TemplateRenderer
{
    /**
     * Icons class constructor
     */
    public function __construct(Icon $element)
    {
        parent::__construct($element);
    }


    /**
     * Render the icon HTML
     *
     * @note This render skips the parent Element class rendering for speed and simplicity
     * @return string|null
     */
    public function render(): ?string
    {
        $this->component->addClass('fa-lg');
        $html = parent::render();
        return '<span>' . $html . '</span>';
    }
}