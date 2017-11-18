<?php

namespace ST\AppBundle\Controller;

use ST\AppBundle\Entity\Comment;
use ST\AppBundle\Entity\Trick;
use ST\AppBundle\Form\Type\CommentType;
use ST\AppBundle\Form\Type\TrickEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ST\AppBundle\Form\Type\TrickType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TrickController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $listTricks = $this->getDoctrine()
            ->getManager()
            ->getRepository('STAppBundle:Trick')
            ->getTricks();
        $listCategories = $this->getDoctrine()
            ->getManager()
            ->getRepository('STAppBundle:Category')
            ->findAllByName();

        return $this->render('AppBundle/index.html.twig', array(
            'listTricks' => $listTricks,
            'listCategories' => $listCategories
        ));
    }

    /**
     * @param $slug
     * @param $page
     * @param $request
     * @return Response
     * @Route("/trick/{slug}/{page}", name="trick", defaults={"page": 1})
     * @Method({"GET", "POST"})
     */
    public function viewAction($slug, $page, Request $request)
    {
        if ($page < 1)
        {
            throw new NotFoundHttpException("La page n'existe pas");
        }

        $nbPerPage = 10;

        $em = $this->getDoctrine()->getManager();
        $trickRepository = $em->getRepository('STAppBundle:Trick');
        $commentRepository = $em->getRepository('STAppBundle:Comment');

        $trick = $trickRepository->findBySlug($slug);
        $trick_id = $trick->getId();
        $listComments = $commentRepository->findByTrick($trick_id, $page, $nbPerPage);

        $nbPages = ceil(count($listComments) / $nbPerPage);

        if ($page > $nbPages && $page != 1)
        {
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }

        $comment = new Comment();
        $comment->setCreationDate(new \DateTime());
        $comment->setTrick($trick);
        $user= $this->getUser();
        if (isset($user))
        {
            $comment->setAuthor($user);
        }

        $form = $this->createForm(CommentType::class, $comment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash('comment-msg', "Commentaire bien ajouté!");

            return $this->redirectToRoute('trick', array('slug' => $slug, 'page' => 1));
        }

        if ($trick === null)
        {
            throw new NotFoundHttpException("Le trick n'existe pas");
        }

        return $this->render(
            ':AppBundle:trick.html.twig', array(
                'trick' => $trick,
                'listComments' => $listComments,
                'nbPages' => $nbPages,
                'page' => $page,
                'form' => $form->createView()
            )
        );
    }

    /**
     * @param $slug
     * @return Response
     * @Route("/group/{slug}", name="group")
     * @Method({"GET"})
     */
    public function viewCategoryAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryTrick = $em->getRepository('STAppBundle:Trick');
        $repositoryGroup = $em->getRepository('STAppBundle:Category');

        $group = $repositoryGroup->findBySlug($slug);
        $id = $group->getId();
        $listTricks = $repositoryTrick->getGroupTricks($id);
        $listCategories = $repositoryGroup->findAllByName();

        if ($group === null)
        {
            throw new NotFoundHttpException("Le groupe n'existe pas");
        }

        return $this->render(
            ':AppBundle:group.html.twig', array(
                'group' => $group,
                'listTricks' => $listTricks,
                'listCategories' => $listCategories
            )
        );
    }

    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/add", name="add")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     * @Method({"GET", "POST"})
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
            $attachments = $trick->getImages();

            foreach ($attachments as $attachment)
            {
                $trick->addImage($attachment);
                $attachment->setTrick($trick);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            $this->addFlash('message', "Trick bien enregistré!");

            return $this->redirectToRoute('home');
        }

        return $this->render('AppBundle/add.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param $slug
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/edit/{slug}", name="edit")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     * @Method({"GET", "PUT"})
     */
    public function editAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('STAppBundle:Trick')->findBySlug($slug);

        if ($trick === null)
        {
            throw new NotFoundHttpException("Le trick n'existe pas");
        }

        $form = $this->createForm(TrickEditType::class, $trick);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $attachments = $trick->getImages();

            foreach ($attachments as $attachment)
            {
                $trick->addImage($attachment);
                $attachment->setTrick($trick);
            }

            $em->flush();

            $this->addFlash('message', "Trick bien modifié");

            $newSlug = $trick->getSlug();

            return $this->redirectToRoute('trick', array('slug' => $newSlug));
        }

        return $this->render(':AppBundle:edit.html.twig', array(
            'trick' => $trick,
            'form'  => $form->createView()
        ));
    }

    /**
     * @param $slug
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/delete/{slug}", name="delete")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('STAppBundle:Trick')->findBySlug($slug);

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

            return $this->redirectToRoute('home');
        }

        return $this->render(':AppBundle:delete.html.twig', array(
            'trick'    => $trick,
            'form'      => $form->createView()
        ));
    }
}
