<?php
namespace JaiUneIdee\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CorrectLocalisationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('site:unique:definelocalisation')
            ->setDescription('remplacer les localisation null par France')
            //->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?')
            //->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        //récupérer les idées crées dans la journée.
        $localisation = $em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("nom"=>"France"));
        
        $users = $em->getRepository('JaiUneIdeeUtilisateurBundle:User')->findBy(array("localisation"=>null));
        foreach($users as $user){
            $user->setLocalisation($localisation);
            $em->persist($user);
            $em->flush();
        }
        $text = "localisations définies";
        $output->writeln($text);
    }
}