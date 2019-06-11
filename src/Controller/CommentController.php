<?php


namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/showmorecomments", name="showmorecomments", methods="POST")
     * @param Request $req
     *
     * @return JsonResponse
     */
    public function showMoreComments(Request $req): jsonresponse
    {

        $offset = $req->get('offset');
        $id = $req->get('id');
        $comments = $this->commentRepository->findComments($offset, $id);
        $response = array(
            'html' => $this->renderView('showmore/comment.html.twig', array('comments' => $comments))
        );

        return $this->json(
            json_encode($response)
        );
    }

}