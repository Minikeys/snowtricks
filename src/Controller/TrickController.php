<?php


namespace App\Controller;


use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @var TrickRepository
     */
    private $repository;

    public function __construct(TrickRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/tricks/{slug}-{id}", name="trick.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Trick $trick
     * @param string $slug
     *
     * @return Response
     */
    public function show(Trick $trick, string $slug) : Response
    {
        if ($trick->getSlug() !== $slug){

            return $this->redirectToRoute('trick.show',[
                'id' => $trick->getId(),
                'slug' => $trick->getSlug()
            ], 301);

        }
        return $this->render('pages/show.html.twig', [
            'trick' => $trick,
            'current_menu' => 'home'
        ]);
    }

}