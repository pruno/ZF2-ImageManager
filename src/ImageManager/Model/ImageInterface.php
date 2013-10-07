<?php

namespace ImageManager\Model;

/**
 * Class ImageInterface
 * @package ImageManager\Model
 */
interface ImageInterface
{
    /**
     * @param $id
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $blob
     */
    public function setBlob($blob);

    /**
     * @return string
     */
    public function getBlob();
}