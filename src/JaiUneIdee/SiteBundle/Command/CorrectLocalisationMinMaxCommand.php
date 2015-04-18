<?php
namespace JaiUneIdee\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use JaiUneIdee\LocalisationBundle\Entity\Localisation;

class CorrectLocalisationMinMaxCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('site:unique:localisationminmax')
            ->setDescription('corriger les localisations min et max. Attention, ne pas executer 2 fois')
            //->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?')
            //->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        //récupérer les idées crées dans la journée.
        $localisations = $em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findAllIdScalar();
        $correction = 0;
        $niveauPrecedent = 0;
        $batchSize = 500;
        $i = 0;
        foreach($localisations as $localisation_scalar){
            $localisation = $em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->find($localisation_scalar['id']);
            $nbEnfant = $this->countEnfant($em, $localisation);
            if(is_numeric($nbEnfant)){
                if($niveauPrecedent>$localisation->getNiveau()){
                    $correction += $niveauPrecedent-$localisation->getNiveau();
                }
                $localisation->setMin($localisation->getMin() + $correction);
                $newMax = $localisation->getMin()+1+$nbEnfant*2;
                echo "Update $localisation, Nb Enfants : $nbEnfant \n";
                $localisation->setMax($newMax);
                $em->persist($localisation);
                $i++;
                if (($i % $batchSize) === 0) {
                    $em->flush();
                    $em->clear(); // Detaches all objects from Doctrine!
                }
                $niveauPrecedent = $localisation->getNiveau();
                if($nbEnfant==0){
                    //update min
                    $correction ++;
                }
            }
        }
        $em->flush(); //Persist objects that did not make up an entire batch
        $em->clear();
        $text = "localisations min max définis";
        $output->writeln($text);
    }
    private function countEnfant($em, Localisation $localisation){
        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(DISTINCT l1.id)+COUNT(DISTINCT l2.id)+COUNT(DISTINCT l3.id)')
           ->from("JaiUneIdee\LocalisationBundle\Entity\Localisation", "l")
           ->leftJoin("l.enfants", "l1")
           ->leftJoin("l1.enfants", "l2")
           ->leftJoin("l2.enfants", "l3")  
           ->andWhere('l.id = :id')
           ->setParameter("id", $localisation->getId())
           ;
        $result= $qb->getQuery()->getSingleScalarResult();
    	return $result;
    }
}