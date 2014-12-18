<?php

namespace Lyon1\Bundle\PoobleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Lyon1\Bundle\PoobleBundle\Entity\SurveyAnswer;
use Lyon1\Bundle\PoobleBundle\Form\SurveyAnswerType;


class ParticipateSurveyController extends Controller
{
    /**
     * @Route("/participate/{token}", name="participate")
     * @Template()
     */
    public function newAction(Request $request, $token)
    {   
        # recupération du survey
        $em = $this->getDoctrine()->getManager();
        $survey = $em->getRepository('PoobleBundle:Survey')->findOneBy(array('token' => $token));
        if (null == $survey) {
            throw $this->createNotFoundException("token invalide");
        }
        
        $answer = new SurveyAnswer();
        $answer->setSurvey($survey);
        $form = $this->createForm(new SurveyAnswerType(), $answer);
        $form->add('Valider', 'submit');
        
        return array(
            'survey' => $survey,
            'form' => $form->createView()
        );
    }

}
