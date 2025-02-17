<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'wish_')]
final class WishController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('wish/index.html.twig', [
            'title' => 'Wishes',
            'wishes' => $em->getRepository(Wish::class)->findAll(),
        ]);
    }
    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id, WishRepository $wishR): Response
    {
        $wish = $wishR->find($id);

        // Exception
        if (!$wish) {
            throw $this->createNotFoundException("Ce souhait n'existe pas.");
        }

        return $this->render('wish/show.html.twig', [
            'title' => 'Wish Detail',
            'wish' => $wish,
        ]);
    }

    #[Route('/fakedata', name: 'fake', methods: ['GET'])]
    public function fakeNew(EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $wish->setTitle("Partir en vacances")
            ->setDescription("Vite")
            ->setAuthor("Bibi")
            ->setIsPublished(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        $wish1 = new Wish();
        $wish1->setTitle("Partir en vacances encore")
            ->setDescription("Juste après")
            ->setAuthor("Encore Bibi")
            ->setIsPublished(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        $wish2 = new Wish();
        $wish2->setTitle("Boire un coup")
            ->setDescription("quand il sera le moment")
            ->setAuthor("Océane")
            ->setIsPublished(true)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        $wish3 = new Wish();
        $wish3->setTitle("Tirer sur Amélie")
            ->setDescription("Mouahahahahahhaha")
            ->setAuthor("Bibi")
            ->setIsPublished(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        $wish4 = new Wish();
        $wish4->setTitle("Vengeance")
            ->setDescription("Tim, je t'oublie pas")
            ->setAuthor("Bibi")
            ->setIsPublished(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        // Persist
        $em->persist($wish);
        $em->persist($wish1);
        $em->persist($wish2);
        $em->persist($wish3);
        $em->persist($wish4);
        // Flush Final
        $em->flush();

        return $this->redirectToRoute('wish_list');
    }
}
