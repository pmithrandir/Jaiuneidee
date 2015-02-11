<?php
namespace JaiUneIdee\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestServeurCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('site:testserveur')
            ->setDescription('effectuer un lot de tests sur le serveur.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        //récupérer les idées crées dans la journée.
        $idees = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getLatestIdees24h();
        if(count($idees)>0){
            $text = "DATABASE OK\n";
        }
        else{
            $text = "DATABASE PROBLEM\n";
        }
        $host = $this->getContainer()->get('router')->getContext()->getHost();
        $mail_service = $this->getContainer()->get('jai_une_idee_site.mailer');
        $mailer = $mail_service->getMailer();
        if($mail_service->sendTestMessage("jaiuneidee.net@gmail.com",$host)){
            $text .= "EMAIL OK\n";
        }
        else{
            $text .= "EMAIL PROBLEM\n";
        }
        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->getContainer()->get('swiftmailer.transport.real');
        $spool->flushQueue($transport);
        
        $output->writeln($text);
    }
}