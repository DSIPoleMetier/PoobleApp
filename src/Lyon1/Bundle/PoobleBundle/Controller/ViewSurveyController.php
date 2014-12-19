<?php

namespace Lyon1\Bundle\PoobleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Lyon1\Bundle\PoobleBundle\Entity\SurveyAnswer;
use Lyon1\Bundle\PoobleBundle\Form\SurveyAnswerType;
use Lyon1\Bundle\PoobleBundle\Entity\SurveyAnswerItem;


class ViewSurveyController extends Controller
{
    /**
     * @Route("/view/{token}", name="view")
     * @Template("PoobleBundle:ParticipateSurvey:new.html.twig")
     */
    public function newAction(Request $request, $token)
    {   
        # recupération du survey
        $em = $this->getDoctrine()->getManager();
        $survey = $em->getRepository('PoobleBundle:Survey')->findOneBy(array('token' => $token));
        if (null == $survey) {
            throw $this->createNotFoundException("token invalide");
        }
        
        
        return array(
            'survey' => $survey
        );
    }

}
