<?php

namespace IT\DynamicFormsBundle\Controller;

use IT\DynamicFormsBundle\Entity\Form;
use IT\DynamicFormsBundle\Entity\FormResponse;
use IT\DynamicFormsBundle\Form\DynamicForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DFController extends Controller
{
    /**
     * @Route("/form-test")
     * @Template()
     */
    public function formTestAction(Request $request)
    {

        /** @var Form $formEntity */
        $formEntity = $this->getDoctrine()->getRepository('ITDynamicFormsBundle:Form')->getFormByName('contact');

        $formResponse = new FormResponse();
        $formResponse->setForm($formEntity);

        $form = $this->createForm(DynamicForm::class, $formResponse);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->getDoctrine()->getManager()->persist($formResponse);
                $this->getDoctrine()->getManager()->flush();

            } else {
                dump($form->getErrors());
                exit($form->getErrorsAsString());
            }


        }

        return array(
            'form' => $form->createView(),
        );
    }
}
