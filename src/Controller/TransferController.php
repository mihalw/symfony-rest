<?php

namespace App\Controller;

use App\Entity\Transfer;
use App\Entity\Rider;
use App\Entity\Team;
use App\Form\TransferType;
use App\Form\RiderType;
use App\Repository\TransferRepository;
use App\Repository\RiderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/transfers")
 */
class TransferController extends AbstractController
{
    /**
     * @Route("/", name="transfer_index", methods={"GET"})
     */
    public function index(TransferRepository $transferRepository): Response
    {
        return $this->render('transfer/index.html.twig', [
            'transfers' => $transferRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="transfer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $transfer = new Transfer();
        $form = $this->createForm(TransferType::class, $transfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $riderId = $transfer->getRiderId();
            $transferTo = $transfer->getToTeam();
            $transferCost = $transfer->getCost();

            $rider = $entityManager->getRepository(Rider::class)->find($riderId);
            $riderName = $rider->getName();
            $riderSurname = $rider->getSurname();
            $transferFrom = $rider->getTeam();
            $transfer->setFromTeam($transferFrom);
            $transfer->setRiderName($riderName);
            $transfer->setRiderSurname($riderSurname);

            if (!$rider) {
                 throw $this->createNotFoundException(
                     'No rider found for id '.$riderId
            );
            }

            $rider->setTeam($transferTo);

            $teamFrom = $entityManager->getRepository(Team::class)->findOneBy(['name' => $transfer->getFromTeam()]);
            $teamTo = $entityManager->getRepository(Team::class)->findOneBy(['name' => $transfer->getToTeam()]);

            if (!$teamFrom) {
                 throw $this->createNotFoundException(
                     'No team found for id '.$transfer->getFromTeam()
            );
            }
            if (!$teamTo) {
                 throw $this->createNotFoundException(
                     'No team found for id '.$transfer->getToTeam()
            );
            }

            $teamFrom->setBudget($teamFrom->getBudget() + $transferCost);
            $teamTo->setBudget($teamTo->getBudget() - $transferCost);
            $entityManager->persist($teamTo);
            $entityManager->persist($teamFrom);
            $entityManager->persist($transfer);
            $entityManager->persist($rider);
            $entityManager->flush();
            return $this->redirectToRoute('transfer_index');
        }

        return $this->render('transfer/new.html.twig', [
            'transfer' => $transfer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transfer_show", methods={"GET"})
     */
    public function show(Transfer $transfer): Response
    {
        return $this->render('transfer/show.html.twig', [
            'transfer' => $transfer,
        ]);
    }
}
