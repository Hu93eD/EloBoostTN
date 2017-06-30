<?php

namespace EloBoostBundle\Controller;

use EloBoostBundle\Entity\Notification;
use EloBoostBundle\Entity\Payment;
use EloBoostBundle\Entity\User;
use EloBoostBundle\Form\PaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('@EloBoost/Default/verify-step1.html.twig');
    }
    public function firstStepAction(Request $request){
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $boost=$em->getRepository('EloBoostBundle:Boost')->findOneByCode($request->get('BoostCode'));
            try{
                $boost->getId();}
            catch (FatalErrorException $fatalErrorException){
                return new Response('<h1 style="color: red;">Verify your code</h1>');
            }
            $Encrypted = $this->get('nzo_url_encryptor')->encrypt($boost->getId());

            return $this->redirectToRoute('payment_verify2',array('boost'=>$Encrypted));
        }
        return $this->render('@EloBoost/Default/verify-step1.html.twig');
    }
    public function secondStepAction(Request $request,$boost){
        $boo=$this->get('nzo_url_encryptor')->decrypt($boost);

        $em = $this->getDoctrine()->getManager();
        $bost=$em->getRepository('EloBoostBundle:Boost')->findOneById($boo);
        $userid=$bost->getUserId();
        $user=$em->getRepository('EloBoostBundle:User')->findOneById($userid);
        $payment = new Payment();
        $payment->setBoost($bost);
        $payment->setUserId($user);
        $payment->setStatus(false);
        $em->persist($payment);

        $editForm = $this->createForm(PaymentType::class,$payment);
        $editForm->handleRequest($request);
        if($editForm->isSubmitted()){
            $em->getRepository('EloBoostBundle:Payment')->updatetransnumber($editForm->getData()->getId(),$editForm->getData()->getTransactionNumber());
            $notification=new Notification();
            $notification->setType('New Transaction');
            $em->persist($notification);
            $em->flush();
            return new Response("Success");
        }
        return $this->render('@EloBoost/Default/verify-step2.html.twig',array('form'=>$editForm->createView()));
    }
}
