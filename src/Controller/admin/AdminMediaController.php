<?php


namespace App\Controller\admin;


use App\Entity\Media;
use App\Entity\Trick;
use App\Form\AddMediaMovieType;
use App\Form\AddMediaPictureType;
use App\Repository\MediaRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
     * @param Trick $trick
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     * @Route("/admin/trick/add/media/{id}", name="admin.trick.add.media", methods="GET|POST")
     */
    public function addMedia(Trick $trick, Request $request)
    {
        $id = $request->attributes->get('id');
        $media = new Media();
        $formpicture = $this->createForm(AddMediaPictureType::class, $media, [
        'action' => $this->generateUrl('admin.trick.add.media', array('id' => $id)),
            'method' => 'POST',
        ]);
        $formmovie = $this->createForm(AddMediaMovieType::class, $media, [
            'action' => $this->generateUrl('admin.trick.add.media', array('id' => $id)),
            'method' => 'POST',
        ]);
        $formpicture->handleRequest($request);
        $formmovie->handleRequest($request);

        if($formpicture->isSubmitted()){

            if($formpicture->isValid()){

                $picturefile = $formpicture['file']->getData();

                if($picturefile){
                    $newFilename = uniqid().'.'.$picturefile->getClientOriginalExtension();

                    try {
                        $picturefile->move(
                            $this->getParameter('media_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    $media->setFile($newFilename);
                    $media->setAddedAt(new DateTime());
                    $media->setTrick($trick);
                    $media->setType('picture');
                    $this->em->persist($media);
                    $this->em->flush();

                    $newmedia = $this->getParameter('dir_media').$newFilename;
                    $newmedia_id = $media->getId();
                    $deletelink = $this->generateUrl('admin.trick.delete.media', array('id' => $newmedia_id));


                    $response = ['media' => $newmedia,
                        'media_id' => $newmedia_id,
                        'media_deletelink' => $deletelink,
                        'message' => 'success'];

                    return new JsonResponse(json_encode($response));
                }
            }else{
                $errors = array();
                foreach ($formpicture->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                };
                $response = ['error' => $errors,
                    'message' => 'error'];

                return new JsonResponse(json_encode($response));

            }
        }

        if($formmovie->isSubmitted()){

            if($formmovie->isValid()){
                $link = $formmovie['link']->getData();
                $url = parse_url($link);

                $host = $url['host'];

                if(strpos($host, 'youtube') !== false){
                    $query = $url['query'];
                    parse_str($query, $data);
                    $id_video = $data['v'];
                    $media->setLink($id_video);
                    $media->setType('youtube');
                    $media->setTrick($trick);
                    $media->setAddedAt(new DateTime());
                    $this->em->persist($media);
                    $this->em->flush();

                    $response = ['message' => 'success'];

                }elseif (strpos($host, 'dailymotion') !== false){

                    $id_video = strtok(basename($link), '?');
                    $media->setLink($id_video);
                    $media->setType('dailymotion');
                    $media->setTrick($trick);
                    $media->setAddedAt(new DateTime());
                    $this->em->persist($media);
                    $this->em->flush();

                    $response = ['message' => 'success'];

                }else{

                    $response = ['message' => 'error'];

                }


                return new JsonResponse(json_encode($response));
        }else{
                $response = ['message' => 'error'];

                return new JsonResponse(json_encode($response));
            }

        }

        return $this->render('form/addmedia.html.twig', [
            'formmovie' => $formmovie->createView(),
            'formpicture' => $formpicture->createView()
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

            $file = $media->getFile();
            $id = $media->getId();

            if($file){
                $dir = $this->getParameter('media_directory');
                unlink($dir.$file);
            }
            $this->em->remove($media);
            $this->em->flush();

            $response = ['message' => 'success',
            'id' => $id];

            return new JsonResponse(json_encode($response));

        }

        return $this->render('form/deletemedia.html.twig', [
            'media_id' => $media->getId(),
        ]);

    }
}