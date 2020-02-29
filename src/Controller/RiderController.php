<?php

namespace App\Controller;

use App\Entity\Rider;
use App\Form\RiderType;
use App\Repository\RiderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;


/**
 * @Route("/riders")
 */
class RiderController extends AbstractController
{
    /**
     * @Route("/", name="rider_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, RiderRepository $riderRepository): Response
    {	
        $repository = $this->getDoctrine()->getRepository(Rider::class); 
        return $this->render('rider/index.html.twig', [
        'pagination' => $paginator->paginate(
            $repository->findAll(), $request->query->getInt('page', 1),10)
        ]);	

    }

    /**
     * @Route("/new", name="rider_new", methods={"POST", "GET"})
     */
    public function new(Request $request): Response
    {

	$rider = new Rider();
        $form = $this->createForm(RiderType::class, $rider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rider);
            $entityManager->flush();

            return $this->redirectToRoute('rider_index');
        }

        return $this->render('rider/new.html.twig', [
            'rider' => $rider,
            'form' => $form->createView(),
        ]);  
    }

    /**
     * @Route("/{id}", name="rider_show", methods={"GET"})
     */
    public function show(Rider $rider): Response
    {
        return $this->render('rider/show.html.twig', [
            'rider' => $rider,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rider_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rider $rider): Response
    {

        $theEntityId = $rider->getId();
        $expectedVersion = $rider->getVersion();
        $form = $this->createForm(RiderType::class, $rider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $entityManager = $this->getDoctrine()->getManager();
                $entity = $entityManager->getRepository(Rider::class)->find($theEntityId, LockMode::OPTIMISTIC, $expectedVersion );
                $entityManager->flush();

                return $this->redirectToRoute('rider_index');
            }
            catch(OptimisticLockException $e) {
                print "Sorry, but someone else has already changed this entity. Please apply the changes again!";
            }

        } 

        return $this->render('rider/edit.html.twig', [
            'rider' => $rider,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rider_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rider $rider): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rider->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rider);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rider_index');
    }
}
