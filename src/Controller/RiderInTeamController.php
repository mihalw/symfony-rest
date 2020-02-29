<?php

namespace App\Controller;

use App\Entity\RiderInTeam;
use App\Form\RiderInTeamType;
use App\Repository\RiderInTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rider/in/team")
 */
class RiderInTeamController extends AbstractController
{
    /**
     * @Route("/", name="rider_in_team_index", methods={"GET"})
     */
    public function index(RiderInTeamRepository $riderInTeamRepository): Response
    {
        return $this->render('rider_in_team/index.html.twig', [
            'rider_in_teams' => $riderInTeamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rider_in_team_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $riderInTeam = new RiderInTeam();
        $form = $this->createForm(RiderInTeamType::class, $riderInTeam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($riderInTeam);
            $entityManager->flush();

            return $this->redirectToRoute('rider_in_team_index');
        }

        return $this->render('rider_in_team/new.html.twig', [
            'rider_in_team' => $riderInTeam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="rider_in_team_show", methods={"GET"})
     */
    public function show(RiderInTeam $riderInTeam): Response
    {
        return $this->render('rider_in_team/show.html.twig', [
            'rider_in_team' => $riderInTeam,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rider_in_team_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RiderInTeam $riderInTeam): Response
    {
        $form = $this->createForm(RiderInTeamType::class, $riderInTeam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rider_in_team_index');
        }

        return $this->render('rider_in_team/edit.html.twig', [
            'rider_in_team' => $riderInTeam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rider_in_team_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RiderInTeam $riderInTeam): Response
    {
        if ($this->isCsrfTokenValid('delete'.$riderInTeam->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($riderInTeam);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rider_in_team_index');
    }
}
