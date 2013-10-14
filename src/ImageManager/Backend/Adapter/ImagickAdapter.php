<?php

namespace ImageManager\Backend\Adapter;

use ImageManager\Backend\Container\ImagickContainer;
use ImageManager\Model\EditableImageInterface;

/**
 * Class ImagickAdapter
 * @package ImageManager\Backend\Adapter
 */
class ImagickAdapter implements BackendAdapterInterface
{
    /**
     * @param string|null $color
     * @return \ImagickPixel
     */
    protected function getImagickPixel($color = null)
    {
        return new \ImagickPixel($color ? $color : 'white');
    }

    /**
     * @param EditableImageInterface $image
     * @return \Imagick
     */
    protected function getImagick(EditableImageInterface $image)
    {
        /* @var $container \ImageManager\Backend\Container\ImagickContainer */
        $container = $image->getBackendContainer();

        if (
            !$container
            || !$container instanceof ImagickContainer
            || !$container->imagick instanceof \Imagick
        ) {
            $container = new ImagickContainer();
            $container->imagick = new \Imagick();
        }

        return $container->imagick;
    }

    /**
     * @param EditableImageInterface $image
     * @return void
     */
    public function freeContainer(EditableImageInterface $image)
    {
        /* @var $container \ImageManager\Backend\Container\ImagickContainer */
        $container = $image->getBackendContainer();

        if ($container && $container->imagick instanceof \Imagick) {
            $container->imagick->destroy();
        }
    }

    /**
     * @param EditableImageInterface $image
     * @return ImagickContainer
     */
    public function cloneContainer(EditableImageInterface $image)
    {
        /* @var $container \ImageManager\Backend\Container\ImagickContainer */
        $container = $image->getBackendContainer();

        if ($container) {
            $newContainer = clone $container;
            if ($container->imagick instanceof \Imagick) {
                $newContainer->imagick = clone $container->imagick;
            }
        }
    }

    /**
     * @param EditableImageInterface $image
     * @return string
     */
    public function getBlob(EditableImageInterface $image)
    {
        try {
            return $this->getImagick($image)->getimageblob();
        } catch (\ImagickException $e) {
            return '';
        }
    }

    /**
     * @param EditableImageInterface $image
     * @param string $blob
     */
    public function setBlob(EditableImageInterface $image, $blob)
    {
        $this->getImagick($image)->readimageblob($blob);
    }

    /**
     * @param EditableImageInterface $image
     * @return int
     */
    public function getSize(EditableImageInterface $image)
    {
        return $this->getImagick($image)->getimagelength();
    }

    /**
     * @param EditableImageInterface $image
     * @return string
     */
    public function getFormat(EditableImageInterface $image)
    {
        return $this->getImagick($image)->getimageformat();
    }

    /**
     * @param EditableImageInterface $image
     * @param string $format
     * @return void
     */
    public function convert(EditableImageInterface $image, $format)
    {
        $this->getImagick($image)->setimageformat($format);
    }

    /**
     * @param EditableImageInterface $image
     * @return int
     */
    public function getWidth(EditableImageInterface $image)
    {
        return $this->getImagick($image)->getimagesize()['width'];
    }

    /**
     * @param EditableImageInterface $image
     * @return int
     */
    public function getHeight(EditableImageInterface $image)
    {
        return $this->getImagick($image)->getimagesize()['height'];
    }

    /**
     * @param EditableImageInterface $prototype
     * @param int$width
     * @param int $height
     * @param string $backgroundColor
     * @return EditableImageInterface
     */
    public function create(EditableImageInterface $prototype, $width, $height, $backgroundColor = null)
    {
        $image = clone $prototype;
        $container = new ImagickContainer();
        $container->imagick = new \Imagick();
        $container->imagick->newimage(
            $width,
            $height,
            $this->getImagickPixel($backgroundColor)
        );

        $image->setBackendContainer($container);

        return $image;
    }

    /**
     * @param EditableImageInterface $image
     * @param int $degrees
     * @param string $backgroundColor
     * @return void
     */
    public function rotate(EditableImageInterface $image, $degrees, $backgroundColor = null)
    {
        $this->getImagick($image)->rotateimage(
            $this->getImagickPixel($backgroundColor),
            $degrees
        );
    }

    /**
     * @param EditableImageInterface $image
     * @param int $width
     * @param int $height
     * @return void
     */
    public function resize(EditableImageInterface $image, $width, $height)
    {
        $this->getImagick($image)->resizeimage($width, $height, \Imagick::FILTER_LANCZOS, 1, true);
    }

    /**
     * @param EditableImageInterface $image
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     * @return void
     */
    public function crop(EditableImageInterface $image, $x, $y, $width, $height)
    {
        $this->getImagick($image)->cropimage($width, $height, $x, $y);
    }

    /**
     * @param EditableImageInterface $image
     * @param EditableImageInterface $compositionImage
     * @param int $x
     * @param int $y
     * @return void
     */
    public function compose(EditableImageInterface $image, EditableImageInterface $compositionImage, $x, $y)
    {
        $this->getImagick($image)->compositeimage(
            $this->getImagick($compositionImage),
            \Imagick::COMPOSITE_OVER,
            $x,
            $y
        );
    }
}