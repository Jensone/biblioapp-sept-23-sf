<?php

namespace App\Controller;

use App\Entity\Format;
use App\Repository\FormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormatController extends AbstractController
{
    #[Route('/format', name: 'app_format')]
    public function index(FormatRepository $format): Response
    {
        return $this->render('format/format.html.twig', [
            'title' => 'Les formats disponibles', 
            'formats' => $format->findAll(),
        ]);
    }

    #[Route('/format/{name}', name: 'app_format_show')]
    public function show(Format $format): Response
    {
        return $this->render('format/show.html.twig', [
            'title' => 'Le format :', 
            'format' => $format,
        ]);
    }

    #[Route('/format/delete/{name}', name: 'app_format_delete')]
    public function delete(
        Format $format,
        EntityManagerInterface $em
        ): Response
    {
        $em->remove($format);
        $em->flush();
        return $this->redirect('app_format');
    }
}
