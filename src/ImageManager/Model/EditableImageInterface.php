<?php

namespace ImageManager\Model;

use ImageManager\Backend\Container\AbstractContainer;
use ImageManager\Model\ImageInterface;

/**
 * Class EditableImageInterface
 * @package ImageManager\Model
 */
interface EditableImageInterface extends ImageInterface
{
    /**
     * @return AbstractContainer
     */
    public function getBackendContainer();

    /**
     * @param AbstractContainer $data
     */
    public function setBackendContainer(AbstractContainer $data);
}