<?php
// /Acme/BlogBundle/Services/Mailer.php

namespace JaiUneIdee\SiteBundle\Services;

use Symfony\Component\Templating\EngineInterface;
use JaiUneIdee\UtilisateurBundle\Entity\User;
class Mailer
{
    protected $mailer;
    protected $templating;
    private $from = "no-reply@jaiuneidee.net";
    private $reply = "no-reply@jaiuneidee.net";
    private $name = "Equipe JaiUneIdee";
    
    public function getMailer(){
        return $this->mailer;
    }
    public function __construct($mailer, EngineInterface $templating)
    {
       $this->mailer = $mailer;
       $this->templating = $templating;
    }

    protected function sendMessage($to, $subject, $body, $txt = "")
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($this->from,$this->name)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body, 'text/html')
            ->addPart($txt, 'text/plain')
            ->setReplyTo($this->reply,$this->name)
            ->setContentType('text/html');

        return $this->mailer->send($mail);
    }
    public function sendInvitationMessage($email, $code, $invitation){
    	$subject = "[JaiUneIdee]Votre code d'invitation";
    	$template = 'JaiUneIdeeSiteBundle:Mail:invitation.html.twig';
    	$template2 = 'JaiUneIdeeSiteBundle:Mail:invitation.txt.twig';
    	$to = $email;
    	$body = $this->templating->render($template, array('code' => $code, 'invitation'=> $invitation));
    	$texte = $this->templating->render($template2, array('code' => $code, 'invitation'=> $invitation));
    	return $this->sendMessage($to, $subject, $body, $texte);
    }
    
    public function sendContactCopy($email, $name, $subject, $body){
    	$subject = "[JaiUneIdee]Votre message aux administrateurs";
    	$template = 'JaiUneIdeeSiteBundle:Mail:message_admin.html.twig';
    	$to = $email;
    	$body = $this->templating->render($template, array('name' => $name, 'subject'=> $subject, 'body'=> $body));
    	return $this->sendMessage($to, $subject, $body);
    }
    public function alerteIdee($user, $idee){
    	$subject = "[JaiUneIdee]L'idée ".$idee->getTitle()." a été commentée";
    	$template = 'JaiUneIdeeSiteBundle:Mail:alerte.html.twig';
    	$template2 = 'JaiUneIdeeSiteBundle:Mail:alerte.txt.twig';
    	$to = $user->getEmail();
    	$body = $this->templating->render($template, array('user' => $user, 'idee'=> $idee));
    	$texte = $this->templating->render($template2, array('user' => $user, 'idee'=> $idee));
    	return $this->sendMessage($to, $subject, $body, $texte);
    }
    
    public function alerteQuotidienne($users, $idees, $news){
        if(count($idees)==1){
            $subject = "[J'ai Une Idee]Une nouvelle idée aujourd'hui";
        }
        else if(count($idees)>0){
            $subject = "[J'ai Une Idee]".count($idees)." nouvelles idées aujourd'hui";
        }
        else{
            $subject = "[J'ai Une Idee]Quoi de neuf ?";
        }
    	$template = 'JaiUneIdeeSiteBundle:Mail:alerteQuotidienne.html.twig';
    	$template2 = 'JaiUneIdeeSiteBundle:Mail:alerteQuotidienne.txt.twig';
    	$body = $this->templating->render($template, array('idees'=> $idees, "news"=>$news));
    	$texte = $this->templating->render($template2, array('idees'=> $idees, "news"=>$news));
        $valid = true;
        foreach($users as $user){
            $to = $user->getEmail();
            if(false === $this->sendMessage($to, $subject, $body, $texte)){
                $valid = false;   
            }
        }
    	return $valid;
    }
}