<?php
namespace JaiUneIdee\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use JaiUneIdee\SiteBundle\Entity\Idee;
use JaiUneIdee\SiteBundle\Entity\AlerteIdee;

class AlerteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('site:alertes')
            ->setDescription('Generer les alertes no crées dans le passé')
            //->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?')
            //->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        //pour toutes les idées ajouter une alerte a l'auteur
        $idees = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->findAll();
        foreach($idees as $idee){
            $alerte = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($idee, $idee->getUser());
            if(!$alerte ){
                    $alerte = new AlerteIdee();
                    $alerte->setIdee($idee);
                    $alerte->setUser($idee->getUser());
            }
            $alerte->setActivated(true);
            $em->persist($alerte);
            $em->flush();
        }
        
        //pour tous les comentaires, ajouter une alerte a l'auteur
        $commentaires = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->findAll();
        foreach($commentaires as $commentaire){
            $alerte = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($commentaire->getIdee(), $commentaire->getUser());
            if(!$alerte ){
                    $alerte = new AlerteIdee();
                    $alerte->setIdee($commentaire->getIdee());
                    $alerte->setUser($commentaire->getUser());
            }
            $alerte->setActivated(true);
            $em->persist($alerte);
            $em->flush();
        }
        
        
        $text = "alertes enregistrées";
        $output->writeln($text);
    }
}