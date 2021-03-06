<?php
namespace JaiUneIdee\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class TestServeurCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('site:testserveur')
            ->addArgument('email', InputArgument::OPTIONAL, 'Email a envoyer à la place de l\'admin par defaut')
            ->setDescription('effectuer un lot de tests sur le serveur.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getArgument('email')) {
            $email = $input->getArgument('email');
        } else {
            $email = 'jaiuneidee.net@gmail.com';
        }
        $em = $this->getContainer()->get('doctrine')->getManager();
        //récupérer les idées crées dans la journée.
        $idees = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getLatestIdees();
        $text ="";
        if(count($idees)>0){
            $text .= "DATABASE OK\n";
        }
        else{
            $text .= "DATABASE PROBLEM\n";
        }
        $index = $this->getContainer()->get('fos_elastica.index.jaiuneidee');
        $idees = $index->search();
        if(count($idees)>0){
            $text .= "ES OK\n";
        }
        else{
            $text .= "ES PROBLEM\n";
        }
        $host = $this->getContainer()->get('router')->getContext()->getHost();
        $mail_service = $this->getContainer()->get('jai_une_idee_site.mailer');
        $mailer = $mail_service->getMailer();
        if($mail_service->sendTestMessage($email,$host)){
            $text .= "EMAIL OK $email \n";
        }
        else{
            $text .= "EMAIL PROBLEM $email \n";
        }
        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->getContainer()->get('swiftmailer.transport.real');
        $spool->flushQueue($transport);
        
        $output->writeln($text);
    }
}