<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\WorldGame;
use WorldBundle\Entity\Player;
use WorldBundle\Entity\Inventory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class GameplayController extends Controller
{

    /**
    * When a user wants to join a worldgame
    * @Route("/joinworldgame/{id}", name="joinworldgame")
    * @Method("GET")
    */
    public function joinWorldAction(WorldGame $worldGame) {

        // creating a new player linked to the user
        $em = $this->getDoctrine()->getManager();
        $player = new Player();
        $player->setStatus("ok");
        // TODO : give the player a real name
        if (!$allPlayers =
            ($em->getRepository('WorldBundle:Player')
                ->findBy(array(),array('id' => 'desc'))))
        {
            $player->setName("Player n°0");
        }
        else {
            $currentPlayerId = $allPlayers[0]->getId();
            $player->setName("Player n°".$currentPlayerId);
        }
        // TODO : link player to user

        // placing the player on an sialdn
        // first we get all the deserted player type islands belonging to the current world
        $islands = $em
            ->getRepository('WorldBundle:Island')
            ->findBy(
                array(
                    'worldgame' => $worldGame->getId(),
                    'type' => 'player',
                    'deserted' => true,
                )
            );
        $nbIslands = count($islands);
        $playerIsland = $islands[random_int(0, $nbIslands-1)];
        $player->setIsland($playerIsland);
        $playerIsland->setDeserted(false);

        // giving a starter bottle to player
        $bottle = $em->getRepository('WorldBundle:Item')->findBy(array('name'=>'bottle'))[0];
        $bottleObject[] = array(
            "item" => $bottle,
            "quantity"=>1
        );
        $em->persist($player);
        $em->flush();

        $player->PickObject($bottleObject);
        $em->persist($player);
        $em->flush();

        return $this->render('island/show.html.twig', array(
            'island' => $playerIsland,
        ));

    }

}