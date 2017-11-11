<?php

namespace ST\AppBundle\Controller;

use ST\AppBundle\Entity\Category;
use ST\AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/add", name="add_category")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(Request $request)
    {
        $group = new Category();

        $form = $this->createForm(CategoryType::class, $group);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            $this->addFlash('message', "Groupe bien enregistré!");

            return $this->redirectToRoute('home', array('page' => 1));
        }

        return $this->render(':AppBundle:category_add.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/delete/{id}", name="delete_category")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('STAppBundle:Category')->find($id);

        if ($group === null)
        {
            throw new NotFoundHttpException("Le groupe n'existe pas");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($group);
            $em->flush();

            $this->addFlash('message', 'Le groupe a bien été supprimée');

            return $this->redirectToRoute('home', array('page' => 1));
        }

        return $this->render(':AppBundle:category_delete.html.twig', array(
            'group'    => $group,
            'form'      => $form->createView()
        ));
    }
}