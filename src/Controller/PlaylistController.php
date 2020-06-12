<?php

namespace App\Controller;

use App\Dto\Request\AddDto;
use App\Dto\Request\CreateDto;
use App\Dto\Request\DeleteDto;
use App\Exception\PlaylistException;
use App\Exception\ValidationException;
use App\Helper\DtoHelper;
use App\Model\PlaylistModel;
use App\Serializer\Serializer;
use App\Validator\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaylistController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     * @param Request $request
     * @return \App\Dto\Response\Response
     */
    public function getList(Request $request)
    {
        // Fetch query parameters
        $owner = $request->query->has('owner') ? $request->query->get('owner') : null;

        // Processing
        $data = PlaylistModel::getAllPlaylistsBy($owner);

        // Response
        return DtoHelper::createResponseDto(Response::HTTP_OK, $data, []);
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     * @param Request $request
     * @return \App\Dto\Response\Response
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        // Deserialize the payload
        $createDto = Serializer::getInstance()->deserialize($request->getContent(), CreateDto::class, 'json');

        // Validate the resulting dto
        $violations = Validator::getInstance()->validate($createDto);
        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }
        // Processing
        $data = PlaylistModel::createPlaylist($createDto);

        // Response
        return DtoHelper::createResponseDto(Response::HTTP_OK, $data, []);
    }

    /**
     * @Route("/add", name="add", methods={"POST"})
     * @param Request $request
     * @return \App\Dto\Response\Response
     * @throws ValidationException|PlaylistException
     */
    public function add(Request $request)
    {
        // Deserialize the payload
        $addDto = Serializer::getInstance()->deserialize($request->getContent(), AddDto::class, 'json');

        // Validate the resulting dto
        $violations = Validator::getInstance()->validate($addDto);
        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }
        // Processing
        $data = PlaylistModel::addToPlaylist($addDto);

        // Response
        return DtoHelper::createResponseDto(Response::HTTP_OK, $data, []);
    }

    /**
     * @Route("/delete", name="delete", methods={"POST"})
     * @param Request $request
     * @return \App\Dto\Response\Response
     * @throws ValidationException|PlaylistException
     */
    public function delete(Request $request)
    {
        // Deserialize the payload
        $deleteDto = Serializer::getInstance()->deserialize($request->getContent(), DeleteDto::class, 'json');

        // Validate the resulting dto
        $violations = Validator::getInstance()->validate($deleteDto);
        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }
        // Processing
        $data = PlaylistModel::deletePlaylist($deleteDto);

        // Response
        return DtoHelper::createResponseDto(Response::HTTP_OK, $data, []);
    }
}
