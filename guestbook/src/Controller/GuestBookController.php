<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Guest;
use App\Form\GuestType;
use Symfony\Component\HttpFoundation\Request;

class GuestBookController extends AbstractController
{
    /**
     * @Route("/guest/book", name="guest_book")
     */
    public function index(Request $request)
    {
		$guest = new Guest();
		$form = $this->createForm(GuestType::class, $guest, [
			'action' => $this->generateUrl('guest_book')		
		]);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			
			$em=$this->getDoctrine()->getManager();
			$user = $this->container->get('security.token_storage')->getToken()->getUser();
			 
			$em->persist($guest);
			//$guest->setUserId($user);
			$em->flush();
			//start DB
		}
        return $this->render('guest_book/index.html.twig', [
            'guest_form'=> $form ->createView()
        ]);
    }
}
