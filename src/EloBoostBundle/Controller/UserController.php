<?php

namespace EloBoostBundle\Controller;

use EloBoostBundle\Entity\User;
use EloBoostBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function addUserAction(Request $Request ,$BoostCodeEncrypted)
    {
        $BoostCode=$this->get('nzo_url_encryptor')->decrypt($BoostCodeEncrypted);
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($Request);
        if ($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $boost=$em->getRepository('EloBoostBundle:Boost')->findOneByCode($BoostCode);
            $boost->setuserId($user);
            $em->flush();
            return new Response('<h1>Your Boost Code (Write it down and dont loose it) : </h1><h2 style="color: #0000F0">'.$BoostCode.'</h2><br>'.'<h2 style="color : red">Our Bank Account : XXXX XXXX XXXX XXXX</h2>');
        }
        return $this->render('@EloBoost/Default/user_add.html.twig',array('form' => $form->createView()));
    }
    public function updateUserAction(Request $request, $idEncrypted){
        $id=$this->get('nzo_url_encryptor')->decrypt($idEncrypted);
        $em=$this->getDoctrine()->getEntityManager();
        $User=$em->getRepository('EloBoostBundle:User')->findOneById($id);
        $form=$this->createForm(UserType::class,$User);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $em->flush();
            return $this->redirectToRoute('user_show');
        }
        return $this->render('@EloBoost/Default/user_update.html.twig',array('form'=>$form->createView()));
    }
    public function showUserAction(){
        $em=$this->getDoctrine()->getEntityManager();
        $users = $em->getRepository('EloBoostBundle:User')->findAll();
        return $this->render('@EloBoost/Default/user_show.html.twig',array('users'=>$users));
    }
    public function deleteAction($idEncrypted){
        $id=$this->get('nzo_url_encryptor')->decrypt($idEncrypted);
        $em=$this->getDoctrine()->getEntityManager();
        $user=$em->getRepository('EloBoostBundle:User')->findOneById($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('user_show');
    }
}
