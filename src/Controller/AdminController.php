<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\RoleType;
use App\Form\RegistrationType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
    * @Route("/admin/admin/listUser", name="admin_admin_listUser")
    */
    public function listUser()
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        $repo1 = $this->getDoctrine()->getRepository(User::class);
        $user = $repo1->findAll();
        $repo2 = $this->getDoctrine()->getRepository(Role::class);
        $role = $repo2->findAll();

        return $this->render('admin/admin/listUser.html.twig', [
            'user' => $user,
            'users' => $users,
            'role' => $role
        ]);
    }

    /**
     * @Route("/admin/admin/newUser", name="app_admin_admin_newUser")
     * @Route("/admin/admin/editUser/{id}", name="app_admin_admin_editUser")
     */
    public function formUser(User $user = null, Role $role = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $currentRoute = $request->attributes->get('_route');
        
        $route = "admin/admin/newUser";
        if($currentRoute == "app_admin_admin_newUser")
            $route = "admin/admin/newUser";
        else if($currentRoute == "app_admin_admin_editUser/{id}")
            $route = "admin/admin/editUser";
        
        if(!$user) {
            $user = new User();
        }
        
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        $repo = $this->getDoctrine()->getRepository(Role::class);
        $role = $repo->findAll();
       
        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash); 
            if($user->getId() == null) {
                $editMode = 0;
                $role[2]->getTitle();
                $user->addUserRole($role[2]);
            }
            else {
                $editMode = 1;
            }           
            $manager->persist($user);        
            $manager->flush();

            return $this->redirectToRoute('admin_admin_listUser');
        }       
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $user->getId() !== null,
            'user' => $user,           
        ]);
    }

    /**
     * @Route("/admin/admin/{id}/deleteUser", name="app_admin_admin_deleteUser")
     */
    public function deleteUser($id, EntityManagerInterface $Manager, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($id);

        $Manager->remove($user);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_admin_listUser');
       
    }

    /**
    * @Route("/admin/admin/listRole", name="admin_admin_listRole")
    */
    public function listRole()
    {
        $repo = $this->getDoctrine()->getRepository(Role::class);
        $roles = $repo->findAll();
        $repo = $this->getDoctrine()->getRepository(role::class);
        $role = $repo->findAll();
       
        return $this->render('admin/admin/listRole.html.twig', [
            'role' => $role,
            'roles' => $roles,
        ]);
    }

    /**
     * @Route("/admin/admin/newRole", name="app_admin_admin_newRole")
     * @Route("/admin/admin/editRole/{id}", name="app_admin_admin_editRole")
     */
    public function formRole(Role $role = null, Request $request, EntityManagerInterface $manager)
    {
        $currentRoute = $request->attributes->get('_route');
        
        $route = "admin/admin/newRole";
        if($currentRoute == "app_admin_admin_newRole")
            $route = "admin/admin/newRole";
        else if($currentRoute == "app_admin_admin_editRole/{id}")
            $route = "admin/admin/editRole";
        
        if(!$role) {
            $role = new Role();
        }
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);       
        if($form->isSubmitted() && $form->isValid()) {
            
            if($role->getId() == null) {
                $editMode = 0; 
            }
            else {
                $editMode = 1;
            }         
            $manager->persist($role);        
            $manager->flush();

            return $this->redirectToRoute('admin_admin_listRole');
        }      
        $html = ".html.twig";
        return $this->render($route.$html, [
            'form' => $form->createView(),
            'editMode' => $role->getId() !== null
        ]);
    }

    /**
     * Liste pour l'affectation des roles
     *
     * @Route("/admin/admin/listAssign", name="admin_admin_listAssign")
     * 
     */
    public function listAssign() {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findAll();
        $repo1 = $this->getDoctrine()->getRepository(User::class);
        $users = $repo1->findAll();
        
        return $this->render('admin/admin/listAssign.html.twig', [
            'user' => $user,
            'users' => $users
        ]);
    }

    /**
    * @Route("/admin/admin/assignRole/{id}", name="admin_admin_assignRole")
    */
    public function assignRole(Request $request, User $user, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);  
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);        
            $manager->flush();

            return $this->redirectToRoute('admin_admin_listRole');
        }     
      
        return $this->render('admin/admin/assignRole.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
