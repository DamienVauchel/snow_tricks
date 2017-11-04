<?php

namespace ST\AppBundle\Controller;

use ST\AppBundle\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ST\AppBundle\Form\TrickType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrickController extends Controller
{
    /**
     * @Route("/{page}", name="home", requirements={"page": "\d*"})
     */
    public function indexAction($page)
    {
        if ($page < 1)
        {
            $page = 1;
        }

        $nbPerPage = 9;

        $listTricks = $this->getDoctrine()
            ->getManager()
            ->getRepository('STAppBundle:Trick')
            ->getTricks($page, $nbPerPage);

        $nbPages = ceil(count($listTricks) / $nbPerPage);

        if ($page > $nbPages)
        {
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }

        return $this->render('AppBundle/index.html.twig', array(
            'listTricks' => $listTricks,
            'nbPages' => $nbPages,
            'page' => $page
        ));
    }

    /**
     * @Route("/trick/{id}", name="trick", requirements={"id": "\d*"})
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('STAppBundle:Trick');

        $trick = $repository->find($id);

        if ($trick === null)
        {
            throw new NotFoundHttpException("Le trick n'existe pas");
        }

        return $this->render(
            ':AppBundle:trick.html.twig', array(
                'trick' => $trick
            )
        );
    }

    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/add", name="add")
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $trick = new Trick();
        $trick->setCreationDate(new \DateTime());
        $user= $this->getUser();
        $trick->setAuthor($user);

        $form = $this->createForm(TrickType::class, $trick);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            $this->addFlash('message', "Trick bien enregistré!");

            return $this->redirectToRoute('home');
        }

        return $this->render('AppBundle/add.html.twig', array('form' => $form->createView()));
    }
}
