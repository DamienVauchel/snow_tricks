<?php

namespace ST\AppBundle\Controller;

use ST\AppBundle\Entity\Trick;
use ST\AppBundle\Form\TrickEditType;
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
        $listCategories = $this->getDoctrine()
            ->getManager()
            ->getRepository('STAppBundle:Category')
            ->findAll();

        $nbPages = ceil(count($listTricks) / $nbPerPage);

        if ($page > $nbPages)
        {
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }

        return $this->render('AppBundle/index.html.twig', array(
            'listTricks' => $listTricks,
            'listCategories' => $listCategories,
            'nbPages' => $nbPages,
            'page' => $page
        ));
    }

    /**
     * @Route("/trick/{slug}", name="trick")
     */
    public function viewAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('STAppBundle:Trick');

        $trick = $repository->findBySlug($slug);

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
     * @param $id
     * @return Response
     * @Route("/group/{id}", name="group", requirements={"id": "\d*"})
     */
    public function viewCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryTrick = $em->getRepository('STAppBundle:Trick');
        $repositoryGroup = $em->getRepository('STAppBundle:Category');

        $listTricks = $repositoryTrick->getGroupTricks($id);
        $group = $repositoryGroup->find($id);

        if ($group === null)
        {
            throw new NotFoundHttpException("Le groupe n'existe pas");
        }

        return $this->render(
            ':AppBundle:group.html.twig', array(
                'group' => $group,
                'listTricks' => $listTricks
            )
        );
    }

    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/add", name="add")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
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

            return $this->redirectToRoute('home', array('page' => 1));
        }

        return $this->render('AppBundle/add.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/edit/{id}", name="edit")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('STAppBundle:Trick')->find($id);

        if ($trick === null)
        {
            throw new NotFoundHttpException("Le trick n'existe pas");
        }

        $form = $this->createForm(TrickEditType::class, $trick);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->flush();

            $this->addFlash('message', "Trick bien modifié");

            return $this->redirectToRoute('home', array('page'    => 1));
        }

        return $this->render(':AppBundle:edit.html.twig', array(
            'trick' => $trick,
            'form'  => $form->createView()
        ));
    }

    /**
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/delete/{id}", name="delete")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('STAppBundle:Trick')->find($id);

        if ($trick === null)
        {
            throw new NotFoundHttpException("Le trick n'existe pas");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->remove($trick);
            $em->flush();

            $this->addFlash('message', 'Le trick a bien été supprimée');

            return $this->redirectToRoute('home', array('page' => 1));
        }

        return $this->render(':AppBundle:delete.html.twig', array(
            'trick'    => $trick,
            'form'      => $form->createView()
        ));
    }
}
