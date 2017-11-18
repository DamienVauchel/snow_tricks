<?php

namespace ST\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentController extends Controller
{
    /**
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/delete/{id}", name="delete_comment")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('STAppBundle:Comment')->find($id);

        if ($comment === null)
        {
            throw new NotFoundHttpException("Le commentaire n'existe pas");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($comment);
            $em->flush();

            $this->addFlash('message', 'Le commentaire a bien été supprimée');

            return $this->redirectToRoute('home');
        }

        return $this->render(':AppBundle:comment_delete.html.twig', array(
            'comment'    => $comment,
            'form'      => $form->createView()
        ));
    }
}
