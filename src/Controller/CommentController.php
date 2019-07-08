<?php


namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
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
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(CommentRepository $commentRepository, ObjectManager $em)
    {
        $this->commentRepository = $commentRepository;
        $this->em = $em;
    }

    /**
     * @param Trick $trick
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     * @Route("/admin/trick/addcomment/{id}", name="admin.trick.add.comment", methods="GET|POST")
     */
    public function addComment(Trick $trick, Request $request)
    {
        $comment = New Comment();
        $now = new DateTime();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getUser();

        if($form->isSubmitted()) {

            if ($form->isValid()) {
                $comment->setAddedAt($now);
                $comment->setAuthor($user);
                $comment->setPublished('1');
                $comment->setTrick($trick);
                $this->em->persist($comment);

                $this->em->flush();
                $response = ['message' => 'success'];

                return new JsonResponse(json_encode($response));
            } else {
                $response = ['message' => 'error'];

                return new JsonResponse(json_encode($response));
            }
        }

        return $this->render('form/addcomment.html.twig', [
            'form' => $form->createView(),
        ]);

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