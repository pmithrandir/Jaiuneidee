<?php
namespace JaiUneIdee\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use JaiUneIdee\SiteBundle\Entity\Statistique;

class StatCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('site:stat')
            ->setDescription('Generer les stats du jour')
            //->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?')
            //->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $stat = new Statistique();
        /*
        $name = $input->getArgument('name');
        if ($name) {
            $text = 'Hello '.$name;
        } else {
            $text = 'Hello';
        }

        if ($input->getOption('yell')) {
            $text = strtoupper($text);
        }
        */
        //#####Pour les derenières 24 heures
        //récupérer nb usr connecté dans les 24 dernières heures
        $nbUtilisateursConnectes24 = $em->getRepository('JaiUneIdeeUtilisateurBundle:User')->countUtilisateursConnectes24();
        $stat->setNbUtilisateursConnectes24($nbUtilisateursConnectes24);
        //récupérer le nombre d'idées créé
        $nbIdees24 = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->count24();
        $stat->setNbIdees24($nbIdees24);
        //récupérer le nombre de commentaire créé
        $nbCommentaires24 = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->count24();
        $stat->setNbCommentaires24($nbCommentaires24);
        //récupérer le nombre de votes créé
        $nbVotes24 = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->count24();
        $stat->setNbVotes24($nbVotes24);
        //récupérer le nombre d'inscrits
        $nbInscrits24 = $em->getRepository('JaiUneIdeeUtilisateurBundle:User')->countInscrit24();
        $stat->setNbInscrits24($nbInscrits24);
        //récupérer le nombre d'invitation
        $nbInvitations24 = $em->getRepository('JaiUneIdeeUtilisateurBundle:Invitation')->count24();
        $stat->setNbInvitations24($nbInvitations24);
        //récupérer le nombre d'alertes
        $nbAlertes24 = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->count24();
        $stat->setNbAlertes24($nbAlertes24);
        
        //#Au total
        //nb users
        $nbInscritsTotal = $em->getRepository('JaiUneIdeeUtilisateurBundle:User')->countInscrit();
        $stat->setNbInscritsTotal($nbInscritsTotal);
        //nb idées
        $nbIdeesTotal = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->count();
        $stat->setNbIdeesTotal($nbIdeesTotal);
        //nb commentaires
        $nbCommentairesTotal = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->count();
        $stat->setNbCommentairesTotal($nbCommentairesTotal);
        //nb votes actifs
        $nbVotesTotal = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->count();
        $stat->setNbVotesTotal($nbVotesTotal);
        //nb invitation totao
        $nbInvitationsTotal = $em->getRepository('JaiUneIdeeUtilisateurBundle:Invitation')->count();
        $stat->setNbInvitationsTotal($nbInvitationsTotal);
        //nb invitation totao
        $nbAlertesTotal = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->count();
        $stat->setNbAlertesTotal($nbAlertesTotal);
        
        $stat->setCreatedAt(new \DateTime('-1 day'));
        $em->persist($stat);
        $em->flush();
        $text = "statistiques enregistrées";
        $output->writeln($text);
    }
}