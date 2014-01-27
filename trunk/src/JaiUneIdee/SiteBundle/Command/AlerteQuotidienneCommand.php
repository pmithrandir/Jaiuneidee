<?php
namespace JaiUneIdee\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use JaiUneIdee\SiteBundle\Entity\Idee;
use JaiUneIdee\SiteBundle\Entity\AlerteIdee;

class AlerteQuotidienneCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('site:alertesquotidiennes')
            ->setDescription('Générer les alertes de la journée.')
            //->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?')
            //->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        //récupérer les idées crées dans la journée.
        $news = $em->getRepository('JaiUneIdeeSiteBundle:News')->getNewsPublicToday();
        $idees = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getLatestIdees24h();
        $users = $em->getRepository('JaiUneIdeeUtilisateurBundle:User')->findAllForNewsletter();
        if(count($idees)>0||count($news)>0){
            $mail_service = $this->getContainer()->get('jai_une_idee_site.mailer');
            $mailer = $mail_service->getMailer();
            if($mail_service->alerteQuotidienne($users, $idees,$news)){
                $text = "alertes envoyées";
            }
            else{
                $text = "erreur durant l'envoi des alertes quotidiennes";
            }
            $spool = $mailer->getTransport()->getSpool();
            $transport = $this->getContainer()->get('swiftmailer.transport.real');

            $spool->flushQueue($transport);
        }
        else{
            $text = "pas d'alertes aujourd'hui";
        }
        $output->writeln($text);
    }
}