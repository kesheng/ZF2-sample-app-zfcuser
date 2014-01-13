<?php
namespace Application\Controller;

use Sglib\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManagerInterface;


class AlbumController extends AbstractActionController
{
    protected $albumService;
    protected $albumForm;


     /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        // using $this in the closure, which won’t work. need to pull the controller instance from the event and use it
        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            if (!$controller->zfcUserAuthentication()->hasIdentity()) {
                return $controller->redirect()->toRoute('zfcuser');
            } else {

            }
        }, 100); // execute before executing action logic

        return $this;
    }


    public function indexAction()
    {
          $service = $this->getAlbumService();
          $albums = $service->getAllAlbums();

          return new ViewModel(array(
               'albums' => $albums,
          ));
    }


    public function addAction()
    {
        $service = $this->getAlbumService();

        $form = $this->getAlbumForm();
        $form->get('submit')->setValue('Add');

        $inputFilter = $form->getInputFilter();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost()->toArray();
            $form->setData($data);

            if ($form->isValid()) {
                if ($service->save($data) === true) {
                    // Redirect to list of albums
                    return $this->redirect()->toRoute('album');
                }
            }
        }
        return array('form' => $form);
    }


    public function editAction()
    {
          $id = (int) $this->params()->fromRoute('id', 0);
          if (!$id) {
             return $this->redirect()->toRoute('album', array(
                 'action' => 'add'
             ));
          }

          $service = $this->getAlbumService();
          $album = $service->getAlbumById($id);

          $form = $this->getAlbumForm();
          $form->bind($album);
          $form->get('submit')->setAttribute('value', 'Edit');

          $inputFilter = $form->getInputFilter();
          if ($this->getRequest()->isPost()) {
             $data = $this->getRequest()->getPost()->toArray();
             $form->setData($data);

             if ($form->isValid()) {
                  if ($service->save($data, $album->id) === true) {
                      // Redirect to list of albums
                      return $this->redirect()->toRoute('album');
                  }
             }
          }

          return array(
             'id' => $id,
             'form' => $form,
          );
    }


    public function deleteAction()
    {
          $id = (int) $this->params()->fromRoute('id', 0);
          if (!$id) {
             return $this->redirect()->toRoute('album');
          }

          $service = $this->getAlbumService();
          $album = $service->getAlbumById($id);

          if ($this->getRequest()->isPost()) {
             $del = $this->getRequest()->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $this->getRequest()->getPost('id');
                 $service->delete($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('album');
          }

          return array(
             'id'    => $id,
             'album' => $album
          );
    }


    public function getAlbumService()
    {
        if (empty($this->albumService) === true) {
            $this->albumService = $this->getServiceLocator()->get('Application\Service\Album');
        }

        return $this->albumService;
    }


    public function setAlbumService($albumService)
    {
        $this->albumService = $albumService;

        return $this;
    }


    public function getAlbumForm()
    {
        if (empty($this->albumForm) === true) {
            $this->albumForm = $this->getServiceLocator()->get('Application\Form\AlbumForm');
        }

        return $this->albumForm;
    }


    public function setAlbumForm($albumForm)
    {
        $this->albumForm = $albumForm;

        return $this;
    }
}