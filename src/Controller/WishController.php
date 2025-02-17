<?php

namespace App\Controller;

use App\Entity\Wishes;
use App\Repository\WishesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\Clock\now;

#[Route('/wish', name: 'wish_')]
final class WishController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(EntityManagerInterface $em): Response
    {

        return $this->render('wish/index.html.twig', [
            'title' => 'Wishes',
            'wishes' => $em->getRepository(Wishes::class)->findAll(),
        ]);
    }
    #[Route('/create', name: 'create',methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        if($request->isMethod('POST')) {

            $wish = new Wishes();
            $wish->setTitle($request->get('title'));
            $wish->setDescription($request->get('description'));
            $wish->setCreatedAt(\DateTimeImmutable::createFromFormat('U', now()->format('U')));
            $wish->setAuthor($request->get('author'));
            $wish->setIsPublished($request->get('isPublished'));

            $em->persist($wish);

            $em->flush();

            return $this->redirectToRoute('wish_list');
        }
        return $this->render('wish/create-wish.html.twig', [
            'title' => 'Wishes',
        ]);
    }
    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {


        return $this->render('wish/show.html.twig', [
            'title' => 'Wish Detail',
            'wish' =>  $em->getRepository(Wishes::class)->find($id)
        ]);
    }
}
