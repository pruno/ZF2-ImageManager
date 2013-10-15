<?php

namespace ImageManager\Model;

use ImageManager\Backend\Adapter\BackendAdapterInterface;
use ImageManager\Backend\Container\AbstractContainer;
use ImageManager\Storage\Storage;

/**
 * Class EditableImage
 * @package ImageManager\Model
 */
class EditableImage extends Image implements EditableImageInterface
{
    /**
     * @var BackendAdapterInterface
     */
    protected $backend;

    /**
     * @var AbstractContainer
     */
    protected $container;

    /**
     * @param Storage $storage
     * @param BackendAdapterInterface $backend
     */
    public function __construct(Storage $storage, BackendAdapterInterface $backend)
    {
        parent::__construct($storage);
        $this->setBackend($backend);
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        $this->getBackend()->freeContainer($this);
    }

    /**
     * @return void
     */
    public function __clone()
    {
        $this->getBackend()->cloneContainer($this);
    }

    /**
     * @param BackendAdapterInterface $backend
     */
    public function setBackend(BackendAdapterInterface $backend)
    {
        $this->backend = $backend;
    }

    /**
     * @return BackendAdapterInterface
     */
    public function getBackend()
    {
        return $this->backend;
    }

    /**
     * @param AbstractContainer $container
     */
    public function setBackendContainer(AbstractContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @return AbstractContainer
     */
    public function getBackendContainer()
    {
        return $this->container;
    }

    /**
     * @return string
     */
    public function getBlob()
    {
        return $this->getBackend()->getBlob($this);
    }

    /**
     * @param string $blob
     */
    public function setBlob($blob)
    {
        $this->getBackend()->setBlob($this, $blob);
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->getBackend()->getSize($this);
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->getBackend()->getWidth($this);
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->getBackend()->getHeight($this);
    }

    /**
     * @return float
     */
    public function getRatio()
    {
        return (
            $this->getBackend()->getWidth($this)
            / $this->getBackend()->getHeight($this)
        );
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->getBackend()->getFormat($this);
    }

    /**
     * @param string $format
     */
    public function convert($format)
    {
        $this->getBackend()->convert($this, $format);
    }

    /**
     * @param float $degree
     * @param string $backgroundColor
     */
    public function rotate($degree, $backgroundColor = null)
    {
        $this->getBackend()->rotate($this, $degree, $backgroundColor);
    }

    /**
     * @param int $width
     * @param int $height
     */
    public function resize($width, $height)
    {
        $this->getBackend()->resize($this, $width, $height);
    }

    /**
     * @param int $x
     * @param int $y
     * @param int $with
     * @param int $height
     */
    public function crop($x, $y, $with, $height)
    {
        $this->getBackend()->crop($this, $x, $y, $with, $height);
    }

    /**
     * @param EditableImage $compositionImage
     * @param int $x
     * @param int $y
     * @param string $backgroundColor
     */
    public function compose(EditableImage $compositionImage, $x, $y, $backgroundColor = null)
    {
        $this->getBackend()->compose($this, $compositionImage, $x, $y, $backgroundColor);
    }

    /**
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     * @param string $backgroundColor
     */
    public function selfCompose($width, $height, $x, $y, $backgroundColor = null)
    {
        /* @var $base \ImageManager\Model\EditableImage */
        $base = $this->getBackend()->create(
            new self(
                $this->getStorage(),
                $this->getBackend()
            ),
            $width,
            $height,
            $backgroundColor,
            $this->getFormat()
        );

        $this->getBackend()->compose($base, $this, $x, $y);

        $this->setBackendContainer(
            $base->getBackendContainer()
        );

        $this->getBackend()->cloneContainer($this);
    }

    /**
     * @param int $width
     * @param int $height
     * @param bool $allowUpsample
     * @param string $backgroundColor
     */
    public function fitIn($width, $height, $allowUpsample = false, $backgroundColor = null)
    {
        $oldWidth = $this->getBackend()->getWidth($this);
        $oldHeight = $this->getBackend()->getHeight($this);

        $divX = $oldWidth / $width;
        $divY = $oldHeight / $height;

        if ($oldWidth >= $width || $oldHeight >= $height) {
            if ($divX > $divY) {
                $newWidth = $width;
                $newHeight = $height / $divX;
            } else {
                $newHeight = $height;
                $newWidth = $width / $divY;
            }
        } elseif ($allowUpsample && $divX > $divY) {
            $newWidth = $width;
            $newHeight = $height / $divX;
        } elseif ($allowUpsample) {
            $newHeight = $height;
            $newWidth = $width / $divY;
        } else {
            $newWidth = $oldWidth;
            $newHeight = $oldHeight;
        }

        $this->getBackend()->resize($this, $newWidth, $newHeight);

        $this->selfCompose($width, $height, ($newWidth - $width) / 2, ($newHeight / $height) / 2, $backgroundColor);
    }

    /**
     * @param int $width
     * @param int $height
     * @param bool $allowUpsample
     * @param string $backgroundColor
     */
    public function fitOut($width, $height, $allowUpsample = true, $backgroundColor = null)
    {
        $oldWidth = $this->getBackend()->getWidth($this);
        $oldHeight = $this->getBackend()->getHeight($this);

        $ratio = $oldWidth / $oldHeight;
        $divX = $oldWidth / $width;
        $divY = $oldHeight / $height;

        if ($divX < $divY) {
            $newWidth = !$allowUpsample && $oldWidth <= $width ? $oldWidth : $width;
            $newHeight = $newWidth / $ratio;
        } else {
            $newHeight = !$allowUpsample && $oldHeight <= $height ? $oldHeight : $height;
            $newWidth = $newHeight * $ratio;
        }

        $this->getBackend()->resize($this, $newWidth, $newHeight);

        $this->selfCompose($width, $height, ($newWidth - $width) / 2, ($newHeight / $height) / 2, $backgroundColor);
    }

    /**
     * @param int $width
     */
    public function scaleToWidth($width)
    {
        $oldWidth = $this->getBackend()->getWidth($this);
        $oldHeight = $this->getBackend()->getHeight($this);

        if ($oldWidth == $width) {
            return;
        }

        $newWidth = $width;
        $newHeight = $oldHeight * $width / $oldWidth;

        $this->getBackend()->resize($this, $newWidth, $newHeight);
    }

    /**
     * @param int $height
     */
    public function scaleToHeight($height)
    {
        $oldWidth = $this->getBackend()->getWidth($this);
        $oldHeight = $this->getBackend()->getHeight($this);

        if ($oldHeight == $height) {
            return;
        }

        $newheight = $height;
        $newWidth = $oldWidth * $height / $oldHeight;

        $this->getBackend()->resize($this, $newWidth, $newheight);
    }

    /**
     * @param float $zoom
     */
    public function zoom($zoom)
    {
        $newWidth = $this->getBackend()->getWidth($this) * $zoom / 100;
        $newHeight = $this->getBackend()->getHeight($this) * $zoom / 100;

        $this->getBackend()->resize($this, $newWidth, $newHeight);
    }
}
