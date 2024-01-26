<?php

declare(strict_types=1);


namespace Templates\Mdb\Html\Layouts;

use Phoundation\Web\Html\Renderer;


/**
 * MDB Plugin Grid class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class Grid extends Renderer
{
    /**
     * Grid class constructor
     */
    public function __construct(\Phoundation\Web\Html\Layouts\Grid $element)
    {
        parent::__construct($element);
    }


    /**
     * Render the HTML for this grid
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->render = '';

        foreach ($this->render_object->getSource() as $row) {
            $this->render .= $row->render();
        }

        return parent::render();
    }
}