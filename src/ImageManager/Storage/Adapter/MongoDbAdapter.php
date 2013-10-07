<?php

namespace ImageManager\Storage\Adapter;

use ImageManager\Storage\StorageAdapterInterface;

class MongoDbAdapter implements StorageAdapterInterface
{
    /**
     * @var \MongoCollection
     */
    protected $collection;

    public function __construct(\MongoCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return void
     */
    public function connect()
    {
        // nothing to do
    }

    /**
     * @return void
     */
    public function disconnect()
    {
        // nothing to do
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return true;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function ensureStorage()
    {
        //FIXME should test connection
    }

    /**
     * @return bool
     */
    public function canDeclareIdenfier()
    {
        return true;
    }

    /**
     * @param $id mixed
     * @param $blob string
     * @return mixed
     */
    public function set($id, $blob)
    {
        $data = array(
            'blob' => $blob,
        );

        $this->collection->insert($data);

        return (string) $data['_id'];
    }

    /**
     * @param $id
     * @return bool
     */
    public function has($id)
    {
        return $this->collection->count(array(
           '_id' => $id
        ));
    }

    /**
     * @param $id
     * @return string|bool
     */
    public function get($id)
    {
        $object = $this->collection->findOne(array(
            '_id' => $id
        ));

        return $object ? $object['blob'] : null;
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function delete($id)
    {
        $this->collection->remove(array(
            '_id' => $id
        ));

        return true;
    }
}