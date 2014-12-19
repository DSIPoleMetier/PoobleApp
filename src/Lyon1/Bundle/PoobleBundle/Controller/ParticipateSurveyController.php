<?php

namespace Lyon1\Bundle\PoobleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Lyon1\Bundle\PoobleBundle\Entity\SurveyAnswer;
use Lyon1\Bundle\PoobleBundle\Form\SurveyAnswerType;
use Lyon1\Bundle\PoobleBundle\Entity\SurveyAnswerItem;


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
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $fields = $request->request->all();
            $items=$survey->getItems();
            foreach ($items as $item) {
                $sai = new SurveyAnswerItem();
                $sai->setItem($item);
                $itemId = 'item_'.$item->getId();
                if (isset($fields[$form->getName()][$itemId])) {
                    $sai->setValue($fields[$form->getName()][$itemId]);
                } else {
                    $sai->setValue(0);
                }
                $answer->addAnswerItem($sai);
            }
            
            $em = $this->getDoctrine()->getManager();
            $answer->setCreatedAt(new \DateTime());
            $answer = $em->persist($answer);
            $em->flush();
        }
        
        
        return array(
            'survey' => $survey,
            'form' => $form->createView()
        );
    }

}
