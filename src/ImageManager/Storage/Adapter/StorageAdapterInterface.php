<?php

namespace ImageManager\Storage;

/**
 * Class StorageAdapterInterface
 * @package ImageManager\Storage
 */
interface StorageAdapterInterface
{
    /**
     * @return void
     */
    public function connect();

    /**
     * @return void
     */
    public function disconnect();

    /**
     * @return bool
     */
    public function isConnected();

    /**
     * @return void
     * @throws \Exception
     */
    public function ensureStorage();

    /**
     * @return bool
     */
    public function canDeclareIdentifier();

    /**
     * @return bool
     */
    public function canSave();

    /**
     * @param $id mixed
     * @param $blob string
     * @return string The image id
     */
    public function set($id, $blob);

    /**
     * @param $id
     * @return bool
     */
    public function has($id);

    /**
     * @param $id
     * @return string|bool
     */
    public function get($id);

    /**
     * @param mixed $id
     * @return bool
     */
    public function delete($id);
}