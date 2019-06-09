<?php


namespace App\Controller;


use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
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
     * @Route("/", name="home")
     * @return Response
     */
    public function index() : Response
    {
        $tricks = $this->repository->findFirstTricks();
        $total_tricks = $this->repository->getTotalTricks();
        return $this->render('pages/home.html.twig', [
            'tricks' => $tricks,
            'total_tricks' => $total_tricks,
            'current_menu' => 'home'
        ]);
    }

    /**
     * @Route("/showmoretricks", name="showmoretricks", methods="POST")
     * @param Request $req
     *
     * @return JsonResponse
     */
    public function showMoreTricks(Request $req): jsonresponse
    {

        $offset = $req->get('offset');
        $tricks = $this->repository->findTricks($offset);
        $response = array();
        foreach ($tricks as $trick) {
            $url = $this->generateUrl('trick.show', ['id' => $trick->getId(), 'slug' => $trick->getSlug()]);
            $response[] = array(
                'trick_id' => $trick->getId(),
                'trick_name' => $trick->getName(),
                'trick_slug' => $trick->getSlug(),
                'trick_url' => $url,
                // other fields
            );
        }
        return $this->json(
            json_encode($response)
        );


    }

}