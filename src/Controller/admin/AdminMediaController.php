<?php


namespace App\Controller\admin;


use App\Entity\Media;
use App\Form\AddMediaType;
use App\Repository\MediaRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMediaController extends AbstractController
{
    /**
     * @var MediaRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(MediaRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     * @Route("/admin/trick/add/media/{id}", name="admin.trick.add.media", methods="GET|POST")
     */
    public function addMedia(Request $request)
    {
        $id = $request->attributes->get('id');
        $media = new Media();
        $form = $this->createForm(AddMediaType::class, $media, [
        'action' => $this->generateUrl('admin.trick.add.media', array('id' => $id)),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $media->setTrick($id);
            $media->setAddedAt(new DateTime());
            $this->em->persist($media);
            $this->em->flush();
            $this->addFlash('success', 'Trick edit success');
            $response = ['message' => 'success',
                'id' => $media->getId()];

            return new JsonResponse(json_encode($response));
        }

        return $this->render('form/addmedia.html.twig', [
            'form' => $form->createView(),
            'media' => $media
        ]);

    }


    /**
     * @param Media $media
     * @param Request $request
     *
     * @return Response
     * @Route("/admin/trick/delete/media/{id}", name="admin.trick.delete.media", methods="GET|DELETE")
     *
     */
    public function deleteMedia(Media $media, Request $request)
    {

        if($this->isCsrfTokenValid('delete' . $media->getId(), $request->get('_token'))){

            //$this->em->remove($media);
            //$this->em->flush();

            $response = ['message' => 'success',
            'id' => $media->getId()];

            return new JsonResponse(json_encode($response));

        }

        return $this->render('form/deletemedia.html.twig', [
            'media_id' => $media->getId(),
        ]);

    }
}