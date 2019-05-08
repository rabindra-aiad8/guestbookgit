<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Guest;
use App\Form\GuestType;
use Symfony\Component\HttpFoundation\Request;

class GuestBookControllerTest extends TestCase
{
    /**
     * @Route("/guest/book", name="guest_book")
     */
    public function testIndex(Request $request)
    {
		$guest = new Guest();
		$form = $this->createForm(GuestType::class, $guest, [
			'action' => $this->generateUrl('guest_book')		
		]);
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
		$form['comments'] = 'test comment';
		$form['user_id'] = $user;
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			
			$em=$this->getDoctrine()->getManager();
			
			 
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
