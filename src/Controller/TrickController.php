<?php


namespace App\Controller;


use App\Entity\Trick;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(TrickRepository $trickRepository, CommentRepository $commentRepository)
    {
        $this->trickRepository = $trickRepository;
        $this->commentRepository = $commentRepository;
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
        $id = $trick->getId();
        $formcomment = $this->createForm(CommentType::class, null, [
            'action' => $this->generateUrl('admin.trick.add.comment', array('id' => $id)),
            'method' => 'POST'
        ]);
        if ($trick->getSlug() !== $slug){

            return $this->redirectToRoute('trick.show',[
                'id' => $trick->getId(),
                'slug' => $trick->getSlug()
            ], 301);

        }

        $comments = $this->commentRepository->findFirstComments($id);
        $total_comments= $this->commentRepository->getTotalComments($id);
        return $this->render('pages/show.html.twig', [
            'trick' => $trick,
            'current_menu' => 'home',
            'total_comments' => $total_comments,
            'comments' => $comments,
            'formcomment' => $formcomment->createView(),

        ]);
    }

}