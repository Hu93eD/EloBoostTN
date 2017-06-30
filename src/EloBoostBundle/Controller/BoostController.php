<?php

namespace EloBoostBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use EloBoostBundle\Entity\Boost;
use EloBoostBundle\Form\BoostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class BoostController extends Controller
{
    public function addBoostAction(Request $Request)
    {
        $boost=new Boost();
        if($Request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $boost->setFromLP($Request->get('FROMLP'));
            $boost->setFromDiv($Request->get('FROMDIV'));
            $boost->setFromLG($Request->get('FROMLG'));
            $boost->setToDiv($Request->get('TODIV'));
            $boost->setToLG($Request->get('TOLG'));
            $boost->setPaid('No');
            $boost->setStatus('Waiting');
            $boost->setCode(random_int(10000000,99999999));
            $em->persist($boost);
            $em->flush();
            return $this->redirectToRoute('user_add',array('BoostCodeEncrypted'=>$this->get('nzo_url_encryptor')->encrypt($boost->getCode())));
        }
        return $this->render('@EloBoost/Mobi/boost.html.twig');
    }
    public function showBoostAction(){
        $em = $this->getDoctrine()->getManager();
        $boosts=$em->getRepository('EloBoostBundle:Boost')->findAll();
        return $this->render('',array('Boosts'=>$boosts));
    }
    /*public function setusertoboost($BoostCode , $userid){
        $em=$this->getDoctrine()->getEntityManager();
        $boost=$em->getRepository('EloBoostBundle:Boost')->findOneByCode($BoostCode);
        $boost->setUserId($userid);
        $em->flush();
    }*/
}
