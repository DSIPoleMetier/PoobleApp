<?php

namespace Lyon1\Bundle\PoobleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Lyon1\Bundle\PoobleBundle\Entity\Survey;
use Lyon1\Bundle\PoobleBundle\Form\SurveyType;
use Lyon1\Bundle\PoobleBundle\Factory\SurveyConfigureTypeFactory;

class WizardSurveyController extends Controller
{
    /**
     * @Route("/new", name="pooble_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();

        $survey = new Survey();
        if ($session->has('pending_survey')) {
            $survey = $session->get('pending_survey');
            $survey = $this->getDoctrine()->getManager()->merge($survey);
        }

        $form = $this->createForm(new SurveyType(), $survey);
        $form->add('next', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $session->set('pending_survey', $form->getData());
            $survey->setToken($this->container->get('pooble.tokenizer')->generateToken($survey));
            return $this->redirect($this->generateUrl('pooble_new_configure'));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/new/configure", name="pooble_new_configure")
     * @Template()
     */
    public function newConfigureAction(Request $request)
    {
        $survey = $request->getSession()->get('pending_survey');

        $form = $this->createForm($survey->getCategory()->getType());
        $form->add('end', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            /**
             * Hugly hack due to Doctrine bug:
             * http://www.doctrine-project.org/jira/browse/DDC-2406
             */
            $survey
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
            ;
            // End
            $em = $this->getDoctrine()->getManager();
            $survey = $em->merge($survey);
            $em->flush();

            return $this->redirect($this->generateUrl('pooble_created', array(
                'id' => $survey->getId()
            )));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/created/{id}", name="pooble_created")
     * @Template()
     */
    public function createdAction(Request $request, $id)
    {
        $request->getSession()->remove('pending_survey');

        return array('id' => $id);
    }
}
