<?php

namespace Plugins\Avatars\Robohash;

use Phoundation\Accounts\Users\Interfaces\UserInterface;
use Phoundation\Content\Images\Image;
use Phoundation\Content\Images\Interfaces\ImageInterface;
use Phoundation\Filesystem\Directory;
use Phoundation\Filesystem\Restrictions;
use Phoundation\Web\Http\File;


/**
 * Robohash class
 *
 * This class can connect to the robohash website and download and install robohash avatar images
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2023 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins/Avatars
 */
class Robohash
{
    /**
     * Generate a new avatar and assign it to
     *
     * @param UserInterface $user
     * @return ImageInterface
     */
    public static function generate(UserInterface $user): ImageInterface
    {
        $restrictions = Restrictions::new(DIRECTORY_DATA, true);
        $directory         = DIRECTORY_DATA . 'content/cdn/en/img/profiles/' . $user->getLogId();

        $picture      = File::new($restrictions)->download('https://robohash.org/' . $user->getDisplayName(), function ($file) use ($restrictions, $user, $directory) {
            $directory    = Directory::new($directory, $restrictions)->ensure();
            $picture = Image::new($directory . 'profile.png');

            rename($file, $picture);
            $user->setPicture($picture);

            return $picture;
        });

        return new Image($picture);
    }
}