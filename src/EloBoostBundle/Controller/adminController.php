<?php

namespace EloBoostBundle\Controller;

use EloBoostBundle\Entity\Invitation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class adminController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getEntityManager();

        $Numberofunseenpayments=$this->Numberofunseenpayments();
        $tennotifications=$em->getRepository('EloBoostBundle:Notification')->findLast10();
        $fivenotifications=$em->getRepository('EloBoostBundle:Notification')->findLast5();
        $NotRedeemedRP=$em->getRepository('EloBoostBundle:RPPurchase')->NotRedeemedRP();
        $NotRedeemedRP=$NotRedeemedRP[0];
        $NotRedeemedRP=$NotRedeemedRP[1];
        $Paidbutnotredeemed=$em->getRepository('EloBoostBundle:RPPurchase')->PaidbutnotredemmedRP();
        $Paidbutnotredeemed=$Paidbutnotredeemed[0];
        $Paidbutnotredeemed=$Paidbutnotredeemed[1];

        $paidboosts=$em->getRepository('EloBoostBundle:Boost')->findBy(array('paid'=>'Yes','booster'=>null));
        return $this->render('@EloBoost/admin/dashboard.html.twig',array('Numberofunseenpayments'=>$Numberofunseenpayments[1],'Paidbutnotredeemed'=>$Paidbutnotredeemed,'NotRedeemedRP'=>$NotRedeemedRP,'tennotifications'=>$tennotifications,'fivenotifications'=>$fivenotifications,'paidboosts'=>$paidboosts));
    }

    public function staticsAction(){
        $em=$this->getDoctrine()->getEntityManager();
        $fivenotifications=$em->getRepository('EloBoostBundle:Notification')->findLast5();
        $paidboosts = $em->getRepository('EloBoostBundle:Boost')->countpaid();
        $allboosts = $em->getRepository('EloBoostBundle:Boost')->countall();
        $notpaidboosts = $allboosts[1]-$paidboosts[1];
        $allRP = $em->getRepository('EloBoostBundle:RPPurchase')->countall();
        $PaidRP=$em->getRepository('EloBoostBundle:RPPurchase')->countpaid();

        return $this->render('@EloBoost/admin/statistics.html.twig',array('allRP'=>$allRP[1],'paidRP'=>$PaidRP[1],'fivenotifications'=>$fivenotifications,'allboosts'=>$allboosts[1],'paidboosts'=>$paidboosts[1],'notpaidboosts'=>$notpaidboosts));
    }

    public function invitStaffAction(Request $request)
    {
    }
    public function showBoostsAction(){
        $em=$this->getDoctrine()->getEntityManager();
        $fivenotifications=$em->getRepository('EloBoostBundle:Notification')->findLast5();
        $boosts=$em->getRepository('EloBoostBundle:Boost')->findAll();
        return $this->render('EloBoostBundle:admin:boosts.html.twig',array('fivenotifications'=>$fivenotifications,'boosts'=>$boosts));
    }
    public function showTransactionsAction(){
        $em=$this->getDoctrine()->getEntityManager();
        $fivenotifications=$em->getRepository('EloBoostBundle:Notification')->findLast5();
        $transactions=$em->getRepository('EloBoostBundle:Payment')->findAll();
        $em->getRepository('EloBoostBundle:Payment')->setseen();
        return $this->render('@EloBoost/admin/Transactions.html.twig',array('fivenotifications'=>$fivenotifications,'Transactions'=>$transactions));
    }
    public function showUsersAction(){

    }
    public function showBoostersAction(){

    }
    public function showRPRequestsAction(){

    }

    public function showSingleAccountAction($AccountID)
    {
        $em=$this->getDoctrine()->getEntityManager();
        $fivenotifications=$em->getRepository('EloBoostBundle:Notification')->findLast5();
        $account=$em->getRepository('EloBoostBundle:Account')->findById($AccountID);
        return $this->render('@EloBoost/admin/Accounts.html.twig',array('fivenotifications'=>$fivenotifications,'Accounts'=>$account));
    }

    public function acceptTransactionAction(Request $request,$EncryptedTransactionID){
        $TransactionID=$this->get('nzo_url_encryptor')->decrypt($EncryptedTransactionID);
        $em=$this->getDoctrine()->getEntityManager();
        $transaction=$em->getRepository('EloBoostBundle:Payment')->findOneById($TransactionID);
        $transaction->setStatus(true);
        $boost=$transaction->getBoost();
        if($boost != null)
        $boost->setPaid('Yes');
        $em->flush();
        return $this->redirectToRoute('admin_transactions_show');
    }

    public function refuseTransactionAction(Request $request,$EncryptedTransactionID){
        $TransactionID=$this->get('nzo_url_encryptor')->decrypt($EncryptedTransactionID);
        $em=$this->getDoctrine()->getEntityManager();
        $transaction=$em->getRepository('EloBoostBundle:Payment')->findOneById($TransactionID);
        $em->remove($transaction);
        $em->flush();
        return $this->redirectToRoute('admin_transactions_show');
    }

    public function falseTransactionAction($transactionid){
        $em=$this->getDoctrine()->getEntityManager();
        $transaction = $em->getRepository('EloBoostBundle:Payment')->findOneBy(array('id'=>$transactionid));
        $userid = $transaction->getUserId()->getId();
        $user = $em->getRepository('EloBoostBundle:User')->findOneBy(array('id'=>$userid));
        $useremailaddress = $user->getEmailAddress();
        $mailer=$this->get('mailer');
        $message=$mailer->createMessage()
            ->setSubject('EloBoostTN')
            ->setFrom('eloboosttn@gmail.com')
            ->setTo($useremailaddress)
            ->setBody('<h4>The Transaction code that you enter it is invalid , please check it and repost a valid Transaction code Thanks.</h4>');
        $mailer->send($message);
        return var_dump($useremailaddress);
    }

    public function populatenotification(){

    }

    public function Numberofunseenpayments(){
        $em=$this->getDoctrine()->getEntityManager();
        $numberofunseenpayments=$em->getRepository('EloBoostBundle:Payment')->countunseen();
        return $numberofunseenpayments;
    }

    public function deleteboostAction($id){
        $em=$this->getDoctrine()->getEntityManager();
        $boost=$em->getRepository('EloBoostBundle:Boost')->findOneById($id);
        $em->remove($boost);
        $em->flush();
        return $this->redirectToRoute('admin_boosts_show');
    }

    public function archiveTransactionAction($id){
        $em=$this->getDoctrine()->getEntityManager();
        $transaction=$em->getRepository('EloBoostBundle:Payment')->findOneBy(array('id'=>$id));
        $transaction->setArchived(true);
        $em->flush();
        return $this->redirectToRoute('admin_transactions_show');
    }

    public function unarchiveTransactionAction($id){
        $em=$this->getDoctrine()->getEntityManager();
        $transaction=$em->getRepository('EloBoostBundle:Payment')->findOneBy(array('id'=>$id));
        $transaction->setArchived(false);
        $em->flush();
        return $this->redirectToRoute('admin_transactions_show');
    }

    public function showsingleboostAction($boostcode){
        $em=$this->getDoctrine()->getEntityManager();
        $boost=$em->getRepository('EloBoostBundle:Boost')->findOneByCode($boostcode);
        $fivenotifications=$em->getRepository('EloBoostBundle:Notification')->findLast5();
        return $this->render('EloBoostBundle:admin:boost.html.twig',array('fivenotifications'=>$fivenotifications,'boost'=>$boost));
    }

    public function addStaffAction(Request $request){
        $em=$this->getDoctrine()->getEntityManager();
        $fivenotifications=$em->getRepository('EloBoostBundle:Notification')->findLast5();
        if($request->isMethod('POST')){

            $invitaion = new Invitation();
            $invitaion->setEmail($request->get('email'));
            $invitaion->setRole($request->get('role'));
            $invitaion->send();
            $em->persist($invitaion);
            $em->flush();

            //SwiftMailer --> Send email containing the invitation's code

            $mailer=$this->get('mailer');
            $message=$mailer->createMessage()
                ->setSubject('Welcome Between Us')
                ->setFrom('eloboosttn@gmail.com')
                ->setTo($request->get('email'))
                ->setBody('<strong>Invitation Code : </strong>'.$invitaion->getCode(), 'text/html');
            $mailer->send($message);

            return $this->render('@EloBoost/admin/Staff/addStaff.html.twig',array('invitation_code'=>$invitaion->getCode(),'fivenotifications'=>$fivenotifications));
        }
        return $this->render('@EloBoost/admin/Staff/addStaff.html.twig',array('fivenotifications'=>$fivenotifications,'invitation_code'=>null));
    }

    public function showRPAction(){
        $em=$this->getDoctrine()->getEntityManager();
        $fivenotifications=$em->getRepository('EloBoostBundle:Notification')->findLast5();
        $RPs=$em->getRepository('EloBoostBundle:RPPurchase')->findAll();
        return $this->render('EloBoostBundle:admin:RP.html.twig',array('fivenotifications'=>$fivenotifications,'RPs'=>$RPs));
    }

    public function showAccountAction(){
        $em=$this->getDoctrine()->getEntityManager();
        $fivenotifications=$em->getRepository('EloBoostBundle:Notification')->findLast5();
        $accounts=$em->getRepository('EloBoostBundle:Account')->findAll();
        return $this->render('@EloBoost/admin/Accounts.html.twig',array('fivenotifications'=>$fivenotifications,'Accounts'=>$accounts));

    }

}
