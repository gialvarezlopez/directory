<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use \Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * MedicalDetail controller.
 *
 */
class SetProfileImageController extends Controller
{
    public function getUploadRootDir()
	{
		// the absolute directory path where uploaded
		// documents should be saved
		return  $this->get('kernel')->getRootDir().'/../web/uploads/'; //__DIR__.'/../../../web/uploads/';
	}
    /**
     * Lists all MedicalDetail entities.
     *
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        $oMedical = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array( "usr"=> $userId) );
        if( $oMedical )
        {
            $image = $oMedical->getMdProfileImage();
        }
        else
        {
            $image = "";
        }    
        return $this->render('app/setProfileImage/index.html.twig', array(
            'image' => $image,
        ));
    }

    public function uploadAction( Request $request )
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUsrId();
        
        $croped_image =  $categoryId = $request->get("image");
        if( isset($croped_image) && $croped_image != "" && $request->isMethod('post') )
        {
            try
            {
                $oMedical = $em->getRepository('AppBundle:MedicalDetail')->findOneBy( array( "usr"=> $userId) );

                if( $oMedical && $oMedical->getMdProfileImage() != "" )
                {
                    $oldImage = $oMedical->getMdProfileImage();
                }

                list($type, $croped_image) = explode(';', $croped_image);
                list(, $croped_image)      = explode(',', $croped_image);
                $croped_image = base64_decode($croped_image);
                $image_name = uniqid().time().'.png';
                // upload cropped image to server 
                if( file_put_contents($this->getUploadRootDir().$image_name, $croped_image) )
                {
                    $oMedical->setMdProfileImage($image_name);
                    $em->persist($oMedical);
                    $flush = $em->flush();
                    if( $flush == null)
                    {
                        if( isset($oldImage) && $oldImage != "" )
                        {
                            $this->fileExist( $this->getUploadRootDir().$oldImage);
                            $status = "Image was uploaded successfully";
                            $session->getFlashBag()->add("success", $status);
                            echo 1;
                        }
                    }
                    else
                    {
                        $this->fileExist( $this->getUploadRootDir().$oMedical->getMdProfileImage());
                        echo 0;
                    }
                    
                }
                else
                {
                    
                }

                
            }
            catch (\Exception $e)
            {
                throw $e;
                //echo ($e->getMessage());
            }
        }
        else
        {
            throw new Exception('Error');
        }
        exit();
    }

	
	
	public function fileExist($path)
	{
		if( !empty($path) )
		{
			$fullPath = $path;
			$file_exists = file_exists($fullPath);
			if( $file_exists )
			{
				@unlink($fullPath);
			}else{
                echo "fileexiste";
            }
		}		
	}
	

}
