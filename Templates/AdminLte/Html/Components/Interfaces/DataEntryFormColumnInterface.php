<?php

namespace Templates\AdminLte\Html\Components\Interfaces;

use Phoundation\Web\Html\Components\Input\Interfaces\RenderInterface;


/**
 * Class DataEntryComponentForm
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
interface DataEntryFormColumnInterface
{
    /**
     * Returns the component
     *
     * @return RenderInterface|string|null
     */
    public function getComponent(): RenderInterface|string|null;

    /**
     * Sets the component
     *
     * @param RenderInterface|string|null $component
     * @return static
     */
    public function setComponent(RenderInterface|string|null $component): static;

    /**
     * Renders and returns the HTML for this component
     *
     * @return string|null
     */
    public function render(): ?string;
}