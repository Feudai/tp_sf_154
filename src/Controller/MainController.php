<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function home(): Response
    {
        return $this->render('main/index.html.twig', [
            'title' => 'Home',
        ]);
    }

    #[Route('/about-us', name: 'main_about')]
    public function about(): Response
    {
        $creatorsData = file_get_contents('../assets/resources/team.json');
        $creators = json_decode($creatorsData, true);
        return $this->render('main/about.html.twig', [
            'title' => 'About us',
            'creators' => $creators,
        ]);
    }
}
