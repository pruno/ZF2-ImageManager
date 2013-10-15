<?php

namespace ImageManager\Backend\Adapter;

use ImageManager\Model\EditableImageInterface;
use ImageManager\Backend\Container\AbstractContainer;

/**
 * Class BackendAdapterInterface
 * @package ImageManager\Backend\Adapter
 */
interface BackendAdapterInterface
{
    /**
     * @param EditableImageInterface $image
     * @return void
     */
    public function freeContainer(EditableImageInterface $image);

    /**
     * @param EditableImageInterface $image
     * @return AbstractContainer
     */
    public function cloneContainer(EditableImageInterface $image);

    /**
     * @param EditableImageInterface $image
     * @return string
     */
    public function getBlob(EditableImageInterface $image);

    /**
     * @param EditableImageInterface $image
     * @param string $blob
     * @return void
     */
    public function setBlob(EditableImageInterface $image, $blob);

    /**
     * @param EditableImageInterface $image
     * @return int
     */
    public function getSize(EditableImageInterface $image);

    /**
     * @param EditableImageInterface $image
     * @return string
     */
    public function getFormat(EditableImageInterface $image);

    /**
     * @param EditableImageInterface $image
     * @param string $format
     * @return void
     */
    public function convert(EditableImageInterface $image, $format);

    /**
     * @param EditableImageInterface $image
     * @return int
     */
    public function getWidth(EditableImageInterface $image);

    /**
     * @param EditableImageInterface $image
     * @return int
     */
    public function getHeight(EditableImageInterface $image);

    /**
     * @param EditableImageInterface $prototype
     * @param int$width
     * @param int $height
     * @param string $backgroundColor
     * @param string $format
     * @return EditableImageInterface
     */
    public function create(EditableImageInterface $prototype, $width, $height, $backgroundColor = null, $format = null);

    /**
     * @param EditableImageInterface $image
     * @param int $degrees
     * @param string $backgroundColor
     * @return void
     */
    public function rotate(EditableImageInterface $image, $degrees, $backgroundColor = null);

    /**
     * @param EditableImageInterface $image
     * @param int $width
     * @param int $height
     * @return void
     */
    public function resize(EditableImageInterface $image, $width, $height);

    /**
     * @param EditableImageInterface $image
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     * @return void
     */
    public function crop(EditableImageInterface $image, $x, $y, $width, $height);

    /**
     * @param EditableImageInterface $image
     * @param EditableImageInterface $compositionImage
     * @param int $x
     * @param int $y
     * @return void
     */
    public function compose(EditableImageInterface $image, EditableImageInterface $compositionImage, $x, $y);
}