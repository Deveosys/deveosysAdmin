<?php 

namespace Deveosys\AdminBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends BaseAdminController
{

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = array();
        $meta = $em->getMetadataFactory()->getAllMetadata();
        foreach ($meta as $m) {
            if (strpos($m->getName(), 'AppBundle\\') === 0) {
                $entities[] = [
                    'name' => substr($m->getName(), 17),
                    'objects' => $em->getRepository('AppBundle:'.substr($m->getName(), 17))->findAll(),
                ];
            }
        }
        return $this->render('DeveosysAdminBundle:Admin:dashboard.html.twig', [
            'entities' => $entities
        ]);
    }

    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function persistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::persistEntity($user);
    }

    public function updateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::updateEntity($user);
    }
}