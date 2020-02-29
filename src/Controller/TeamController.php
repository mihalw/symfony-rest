<?php

namespace App\Controller;

use App\Entity\Team;

use App\Entity\Rider;
use App\Form\TeamType;

use App\Form\RiderType;
use App\Repository\TeamRepository;

use App\Repository\RiderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;

/**
 * @Route("/teams")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/", name="team_index", methods={"GET"})
     */
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="team_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_show", methods={"GET"})
     */
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{id}/riders", name="ridersInTeam_show", methods={"GET"})
     */
    public function showRiders(Request $request, Team $team, RiderRepository $riderRepository, TeamRepository $teamRepository, PaginatorInterface $paginator): Response
    {
        $id = $request->get('id');
        $team = $teamRepository->findOneBy(['id' => $id]);
        $teamName = $team->getName();

        $repository = $this->getDoctrine()->getRepository(Rider::class); 
        return $this->render('team/riders.html.twig', [
            'pagination' => $paginator->paginate(
                $repository->findBy(['team' => $teamName]), $request->query->getInt('page', 1),3),
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{id}/riders/{id2}", name="riderInTeam_show", methods={"GET"})
     */
    public function showRiderInTeam(Request $request, Team $team, RiderRepository $riderRepository, TeamRepository $teamRepository): Response
    {
        $id2 = $request->get('id2');
        $rider = $riderRepository->findOneBy(['id' => $id2]); 

        return $this->render('team/riderInTeam.html.twig', [
            'team' => $team,
            'rider' => $rider,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="team_edit", methods={"POST", "GET"})
     */
    public function edit(Request $request, Team $team): Response
    {
        $theEntityId = $team->getId();
        $expectedVersion = $team->getVersion();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entity = $entityManager->getRepository(Team::class)->find($theEntityId, LockMode::OPTIMISTIC, $expectedVersion );
                $entityManager->flush();

                return $this->redirectToRoute('team_index');
            }
            catch(OptimisticLockException $e) {
                print "Sorry, but someone else has already changed this entity. Please apply the changes again!";
            }
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Team $team): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index');
    }
}
