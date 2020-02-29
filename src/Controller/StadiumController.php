<?php

namespace App\Controller;

use App\Entity\Stadium;
use App\Form\StadiumType;
use App\Repository\StadiumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;

/**
 * @Route("/stadiums")
 */
class StadiumController extends AbstractController
{
    /**
     * @Route("/", name="stadium_index", methods={"GET"})
     */
    public function index(StadiumRepository $stadiumRepository): Response
    {
        return $this->render('stadium/index.html.twig', [
            'stadia' => $stadiumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="stadium_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stadium = new Stadium();
        $form = $this->createForm(StadiumType::class, $stadium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get("security.csrf.token_manager")->refreshToken("form_intention");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stadium);
            $entityManager->flush();

            return $this->redirectToRoute('stadium_index');
        }

        return $this->render('stadium/new.html.twig', [
            'stadium' => $stadium,
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/{id}", name="stadium_put", methods={"PUT"})
    //  */
    // public function put(Request $request): Response
    // {
    //     $stadium = new Stadium();
    //     $form = $this->createForm(StadiumType::class, $stadium);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($stadium);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('stadium_index');
    //     }

    //     return $this->render('stadium/new.html.twig', [
    //         'stadium' => $stadium,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/{id}", name="stadium_show", methods={"GET"})
     */
    public function show(Stadium $stadium): Response
    {
        return $this->render('stadium/show.html.twig', [
            'stadium' => $stadium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stadium_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Stadium $stadium): Response
    {
        $theEntityId = $stadium->getId();
        $expectedVersion = $stadium->getVersion();
        $form = $this->createForm(StadiumType::class, $stadium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entity = $entityManager->getRepository(Stadium::class)->find($theEntityId, LockMode::OPTIMISTIC, $expectedVersion );
                $entityManager->flush();

                return $this->redirectToRoute('stadium_index');
            }
            catch(OptimisticLockException $e) {
                print "Sorry, but someone else has already changed this entity. Please apply the changes again!";
            }
        }

        return $this->render('stadium/edit.html.twig', [
            'stadium' => $stadium,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="stadium_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Stadium $stadium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stadium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stadium);
            $entityManager->flush();

            return $this->redirectToRoute('stadium_index');
        }
    }
}
