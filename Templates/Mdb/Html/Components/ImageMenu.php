<?php

declare(strict_types=1);


namespace Templates\Mdb\Html\Components;

use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * MDB Plugin ImageMenu class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class ImageMenu extends TemplateRenderer
{
    /**
     * ImageMenu class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Widgets\ImageMenu $element)
    {
        parent::__construct($element);
    }


    /**
     * Renders and returns the image menu block HTML
     *
     * @return string|null
     */
    public function render(): ?string
    {
        if (!$this->render_object->getImage()) {
            throw new OutOfBoundsException(tr('Cannot render ImageMenu object HTML, no image specified'));
        }
//.        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal" style=""> Launch demo modal </button>

        $this->render = ' <div class="dropdown image-menu">
                            <a class="' . ($this->render_object->getMenu() ? 'dropdown-toggle ' : '') . 'd-flex align-items-center hidden-arrow"
                              href="' . ($this->render_object->getMenu() ? '#' : Html::safe($this->render_object->getUrl())) . '"
                              id="navbarDropdownMenuAvatar"
                              ' . ($this->render_object->getMenu() ? 'role="button" data-mdb-toggle="dropdown"' : ($this->render_object->getModalSelector() ? 'data-mdb-toggle="modal" data-mdb-target="' . Html::safe($this->render_object->getModalSelector()) . '"' : null)) . '                    
                              aria-expanded="false"
                            >';

        $this->render .= $this->render_object->getImage()->getHtmlElement()
            ->setHeight($this->render_object->getHeight())
            ->addClass('rounded-circle')
            ->setExtra('loading="lazy"')
            ->render();

        $this->render .= '  </a>
                            <ul
                              class="dropdown-menu dropdown-menu-end"
                              aria-labelledby="navbarDropdownMenuAvatar"
                            >';

        if ($this->render_object->getMenu()) {
            foreach ($this->render_object->getMenu()->getSource() as $label => $entry) {
                if (is_string($entry)) {
                    // Menu entry data was specified as just the URL in a string
                    $entry = ['url' => $entry];
                }

                $this->render .= '<li>
                                    <a class="dropdown-item" href="' . Html::safe($entry['url']) . '">' . Html::safe($label) . '</a>
                                  </li>';
            }
        }

        $this->render .= '      </ul>
                            </div>' . PHP_EOL;

        return parent::render();
    }
}