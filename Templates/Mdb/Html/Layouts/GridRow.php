<?php

declare(strict_types=1);


namespace Templates\Mdb\Html\Layouts;

use Phoundation\Core\Log\Log;
use Phoundation\Web\Html\TemplateRenderer;


/**
 * MDB Plugin GridRow class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class GridRow extends TemplateRenderer
{
    /**
     * GridRow class constructor
     */
    public function __construct(\Phoundation\Web\Html\Layouts\GridRow $element)
    {
        parent::__construct($element);
    }


    /**
     * Render this grid row
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $return = '<div class="row">';
        $size   = 0;

        foreach ($this->render_object->getSource() as $column) {
            $size   += $column->getSize()->value;
            $return .= $column->render();
        }

        if ($size != 12) {
            Log::warning(tr('GridRow found a row with size ":size" while each row should be exactly size 12', [
                ':size' => $size
            ]));
        }

        return $return . '</div>';
    }
}