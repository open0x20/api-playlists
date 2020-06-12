<?php

namespace App\Model;


use App\Database\Database;
use App\Dto\Request\AddDto;
use App\Dto\Request\CreateDto;
use App\Dto\Request\DeleteDto;
use App\Entity\Playlist;
use App\Exception\PlaylistException;
use App\Repository\PlaylistRepository;

/**
 * Class PlaylistModel
 * @package App\Model
 */
class PlaylistModel
{
    /**
     * @param $owner
     * @return array
     */
    public static function getAllPlaylistsBy($owner)
    {
        $playlistRepo = Database::getInstance()->getRepository(Playlist::class);

        // Fetch playlists form database
        $playlists = [];
        if ($owner !== null) {
            $playlists = $playlistRepo->findBy([
                'owner' => $owner
            ]);
        } else {
            $playlists = $playlistRepo->findAll();
        }

        // map into serializable format
        $result = [];
        foreach ($playlists as $pl) {
            $tracks = json_decode($pl->getData());
            $result[] = [
                'owner' => $pl->getOwner(),
                'name' => $pl->getName(),
                'tracks' => $tracks
            ];

        }

        return $result;
    }

    public static function createPlaylist(CreateDto $createDto)
    {
        $playlist = new Playlist();
        $playlist->setOwner($createDto->owner);
        $playlist->setName($createDto->name);
        $playlist->setData(null);

        Database::getInstance()->persist($playlist);
        Database::getInstance()->flush();

        return [
            'id' => $playlist->getId()
        ];
    }

    public static function addToPlaylist(AddDto $addDto)
    {
        $playlistRepo = Database::getInstance()->getRepository(Playlist::class);
        $playlists = $playlistRepo->findBy([
            'id' => $addDto->playlistId
        ]);

        if (empty($playlists)) {
            throw new PlaylistException('No playlist found for given id.');
        }

        $data = json_decode($playlists[0]->getData());
        $data[] = [
            'id' => $addDto->trackId
        ];

        $playlists[0]->setData($data);

        Database::getInstance()->persist($playlists[0]);
        Database::getInstance()->flush();

        return [
            'id' => $addDto->playlistId
        ];
    }

    public static function deletePlaylist(DeleteDto $deleteDto)
    {
        $playlistRepo = Database::getInstance()->getRepository(Playlist::class);
        $playlists = $playlistRepo->findBy([
            'id' => $deleteDto->playlistId
        ]);

        if (empty($playlists)) {
            throw new PlaylistException('No playlist found for given id.');
        }

        Database::getInstance()->remove($playlists[0]);
        Database::getInstance()->flush();

        return [
            'id' => $deleteDto->playlistId
        ];
    }
}
