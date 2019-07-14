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
        $tricks = $this->repository->findOtherTricks($offset);
        $response = array(
            'html' => $this->renderView('showmore/trick.html.twig', array('tricks' => $tricks))
        );

        return $this->json(
            json_encode($response)
        );
    }

}