<?php
namespace JaiUneIdee\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateLastActionDateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('site:unique:updatelastActionDate')
            ->setDescription('remplacer les localisation null par France')
            //->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?')
            //->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        //récupérer les idées crées dans la journée.
        $idees = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->findBy([], ['updated_at' => 'ASC']);
        $commentaires = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->findBy([], ['updated_at' => 'ASC']);
        foreach($idees as $idee){
            $idee->setLastActionAt($idee->getUpdatedAt());
            $em->persist($idee);
            $em->flush();
        }
        foreach($commentaires as $commentaire){
            $idee = $commentaire->getIdee();
            $idee->setLastActionAt($commentaire->getUpdatedAt());
            $em->persist($idee);
            $em->flush();
        }
        $text = "lastActionAt définies";
        $output->writeln($text);
    }
}