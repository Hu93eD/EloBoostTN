<?php

namespace EloBoostBundle\Controller;

use EloBoostBundle\Entity\Account;
use EloBoostBundle\Entity\Notification;
use EloBoostBundle\Entity\Payment;
use EloBoostBundle\Entity\RPPurchase;
use EloBoostBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RPController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function PurchaseAction(Request $request,$amount){
        $array = [10,20,35,50];
        if(!in_array($amount, $array)){
            return $this->redirectToRoute('elo_boost_homepage');
        }
        $account = new Account();
        /*$form = $this->createForm('EloBoostBundle\Form\AccountType', $account);
        $form->handleRequest($request);*/

        if (/*$form->isSubmitted() && $form->isValid()*/$request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $region = $request->get('region');
            $account->setEmail($request->get('email'));
            $account->setIngamename($request->get('ingamename'));
            $account->setUsername($request->get('username'));
            $account->setPassword($request->get('password'));
            $account->setRegion($region);
            $link='';
            if($region == 'Europe West')
                $link='https://euw.op.gg/summoner/userName=';
            elseif($region == 'Europe Nordic & East')
                $link='https://eune.op.gg/summoner/userName=';
            elseif($region == 'North America')
                $link='https://na.op.gg/summoner/userName=';
            else
                return new \Exception("We Do Not Support This Server Yet");
            $account->setOpgglink($link.$account->getIngamename());
            $RPPuchaseEntity = new RPPurchase();
            $RPPuchaseEntity->setAmount($amount);
            $em->persist($RPPuchaseEntity);
            $em->persist($account);
            $em->flush();
            $EncryptedAccountId = $this->get('nzo_url_encryptor')->encrypt($account->getId());
            $EncryptedRPPurchaseEntity= $this->get('nzo_url_encryptor')->encrypt($RPPuchaseEntity->getId());
            return $this->redirectToRoute('RPPuchase_add_user',array('EncryptedAccountId'=>$EncryptedAccountId,'EncryptedRPPurchaseEntity'=>$EncryptedRPPurchaseEntity));
        }

        return $this->render('EloBoostBundle:Mobi:RP.html.twig'/*'EloBoostBundle:Mobi:Account.html.twig', array('form' => $form->createView(),)*/);
    }
    public function UserAddAction(Request $request , $EncryptedAccountId,$EncryptedRPPurchaseEntity){
        $DescryptedRPPurchaseEntity=$this->get('nzo_url_encryptor')->decrypt($EncryptedRPPurchaseEntity);
        $DecryptedAccountId=$this->get('nzo_url_encryptor')->decrypt($EncryptedAccountId);
        $user = new User();
        /*$form = $this->createForm('EloBoostBundle\Form\UserType', $user);
        $form->handleRequest($request);*/

        if (/*$form->isSubmitted() && $form->isValid()*/$request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $user->setEmailAddress($request->get('email'));
            $user->setBankCC($request->get('bank'));
            $user->setPhoneNumber($request->get('phone'));
            $account=$em->getRepository('EloBoostBundle:Account')->findOneById($DecryptedAccountId);
            $RPPurchase=$em->getRepository('EloBoostBundle:RPPurchase')->findOneById($DescryptedRPPurchaseEntity);
            $account->setUser($user);
            $RPPurchase->setAccount($account);
            $em->persist($user);
            $em->flush();
            return $this->render('@EloBoost/Mobi/code.html.twig',array('code'=>$RPPurchase->getCode()));
        }

        return $this->render('@EloBoost/Mobi/Account.html.twig');

    }

    public function VerifyAction(Request $request)
    {
        if ($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $RPPurchase=$em->getRepository('EloBoostBundle:RPPurchase')->findOneByCode($request->get('RPCode'));
            $user=$RPPurchase->getAccount()->getUser();
            var_dump($request->get('RPCode').$request->get('TrCode'));
            $payment = new Payment();
            $payment->setTransactionNumber($request->get('TrCode'));
            $payment->setRP($RPPurchase);
            $payment->setUserId($user);
            $em->persist($payment);
            $RPPurchase->setTransaction($payment);
            $notification=new Notification();
            $notification->setType('New RP Purchase');
            $em->persist($notification);
            $em->flush();
            return $this->redirectToRoute('elo_boost_homepage');
        }
        return $this->render('EloBoostBundle:Mobi:RPVerify.html.twig');
    }
}
