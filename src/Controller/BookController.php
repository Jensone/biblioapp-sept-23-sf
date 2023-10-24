<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Order;
use App\Form\BookType;
use App\Form\OrderType;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/livres')]
class BookController extends AbstractController
{
    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager
        ): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET', 'POST'])]
    public function show(
        Book $book, 
        Request $request, 
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
        ): Response
    {
        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $start = $form->get('dateStart')->getData();
            $end = $form->get('dateEnd')->getData();
            $buyer = $userRepository->find(['id' => $form->get('buyer')->getData()]);

            // dd($start, $end, $buyer);
            // Calcul du total entre les deux dates * 2.5
            $total = floatval($start->diff($end)->days * 2.5);
            
            // Création de la commande
            $order = new Order();
            $order->setDateStart($start)
                ->setNumber(uuid_create())
                ->setDateEnd($end)
                ->setTotal($total)
                ->setBuyer($buyer)
                ->setStatut(false)
                ;

            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('payment_session', [
                'order' => $order,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
            'orderForm' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Book $book, 
        EntityManagerInterface $entityManager
        ): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
