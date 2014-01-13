<?php

namespace Application\Service;

use Sglib\Service\AbstractService;
use Application\Entity\Album as AlbumEntity;

class Album extends AbstractService
{
    protected $ablumForm;


    public function getAllAlbums()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Album')->findAll();
    }


    public function getAlbumById($id)
    {
        return $this->getEntityManager()->find('Application\Entity\Album', $id);
    }


    public function save($data, $id = null)
    {
        if ($id) {
            $saveObject = $this->getAlbumById($id);
            if (! $saveObject instanceof AlbumEntity) {
                $error = 'invalid id save';
                return false;
            }
        } else {
            $saveObject = new AlbumEntity();
        }

        try {
            $saveObject->title  = $data['title'];
            $saveObject->artist = $data['artist'];

            if ($id == null) {
                $saveObject->createdAt = new \DateTime();;

                $this->getEntityManager()->persist($saveObject);
            }

            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $exception) {
            //var_dump($exception);exit;
            return false;
        }
    }


    public function delete($id)
    {
        $deleteObject = $this->getAlbumById($id);
        if (! $deleteObject instanceof AlbumEntity) {
            $error = 'invalid id delete';
            return false;
        }

        try {
            $this->getEntityManager()->remove($deleteObject);
            $this->getEntityManager()->flush();

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }


    public function getApplicationForm()
    {
        return $this->ablumForm;
    }

    public function setApplicationForm($ablumForm)
    {
        $this->ablumForm = $ablumForm;

        return $this;
    }
}
