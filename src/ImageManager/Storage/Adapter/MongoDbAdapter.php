<?php

namespace ImageManager\Storage\Adapter;

/**
 * Class MongoDbAdapter
 * @package ImageManager\Storage\Adapter
 */
class MongoDbAdapter extends AbstractStorageAdapter
{
    /**
     * @var \MongoCollection
     */
    protected $collection;

    /**
     * @param \MongoCollection $collection
     * @param array $options
     */
    public function __construct(\MongoCollection $collection, array $options = array())
    {
        parent::__construct($options);
        $this->collection = $collection;
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