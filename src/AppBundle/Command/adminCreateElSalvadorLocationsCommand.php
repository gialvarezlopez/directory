<?php

namespace AppBundle\Command;

//use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Country;
use AppBundle\Entity\State;
use AppBundle\Entity\City;

class adminCreateElSalvadorLocationsCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                // the name of the command (the part after "bin/console")
                ->setName('app:generar-ubicaciones-elsalvador')

                // the short description shown while running "php bin/console list"
                ->setDescription('Crea el mapeo de localidades de el salvador')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp("Crea los deparatamentos y municipios de el salvador")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) 
	{
        
		$em = $this->getContainer()->get('doctrine')->getManager();
		//$em = $this->getDoctrine()->getManager();
		
		//======================================================================
		//Municipios
		//======================================================================
		
		
		$oCountry = new Country();
		$oCountry->setCouName( "Australia" );
		$oCountry->setCouActive( 1 ); 
		$em->persist($oCountry);			
		$flush = $em->flush();
		if ($flush == null)
		{
			$output->writeln([
				'',
				'=========================================================',
				'Country Created Succssesfull',
				'=========================================================',
				'',
				//'Medicos a crear: ' . $num,
				//'ID:'.$oCountry->getPaiId(),
			]);
			
			$proStates = 0;
			$totalMuni = 0;
			$output->writeln('Creando States... ');
			$output->writeln('---------------------------------------------------------');

			$RAW_QUERY  = "SELECT * FROM states";

                        $statement  = $em->getConnection()->prepare($RAW_QUERY);
                        $statement->execute();    
                        $states    = $statement->fetchAll();

			foreach ($states as $state)
			{
				//$output->writeln($state['state_code']);
				//Create the state
				$oState = new State();
				//$oState->setStaId( $oCountry );
				$oState->setStaName( $state['state'] );
				$oState->setCou( $oCountry );
				$oState->setStalat( $state['lat'] );
				$oState->setStaLng( $state['lng'] );
				$oState->setStaCode( $state['state_code'] );
				$oState->setStaActive(1);
				
				$em->persist($oState);	

						

				$flush = $em->flush();
				//$idState = $oState->getStaId();
				
				if ($flush == null)
				{
					$proStates++;
					
					$RAW_QUERY  = "SELECT * FROM cities2 where state_code='".$state['state_code']."'";
                        $statement  = $em->getConnection()->prepare($RAW_QUERY);
                        $statement->execute();    
                        $cities    = $statement->fetchAll();
					//$output->writeln('Departamento id: '.$oState->getDepId());
                    $output->writeln($state['state_code']);
					
	
					

					foreach ($cities as $cit )
					{
						//Create the municipality
						$oCity = new City();
						$oCity->setCitName( $cit['city'] );						
						$oCity->setSta( $oState  );
						$oCity->setCitActive(1);
						
						$em->persist($oCity);			
						$flush = $em->flush();

					}										
				}
			}
			$output->writeln('---------------------------------------------------------');
			$output->writeln('Fin');
			/*$output->writeln([
				'',
				'=========================================================',
				'Total '.$proStates." departamentos con ".$totalMuni. ' municipios',
				'=========================================================',
				'',
				//'Medicos a crear: ' . $num,
				//'ID:'.$oCountry->getPaiId(),
			]);*/
		}
		else
		{
			$output->writeln('Error al crear el pais');
		}

    }

}
