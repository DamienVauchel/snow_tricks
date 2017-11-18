<?php

namespace ST\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller
{
    /**
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/delete/{id}", name="delete_image")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('STAppBundle:Image')->find($id);
        $slug = $image->getTrick()->getSlug();

        if ($image === null)
        {
            throw new NotFoundHttpException("L'image n'existe pas");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($image);
            $em->flush();

            $this->addFlash('message', 'L\'image a bien été supprimée');

            return $this->redirectToRoute('trick', array('slug' => $slug));
        }

        return $this->render(':AppBundle:image_delete.html.twig', array(
            'image'    => $image,
            'form'      => $form->createView()
        ));
    }
}
