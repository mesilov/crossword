<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Enum\Type;
use App\Game\Application\Enum\WordCount;
use App\Game\Application\Exception\PlayerNotFoundInTokenStorageException;
use App\Game\Application\Service\Game;
use App\Game\Application\Service\PlayerFromTokenExtractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class NewGameAction extends AbstractController
{
    private PlayerFromTokenExtractor $extractor;

    public function __construct(PlayerFromTokenExtractor $extractor)
    {
        $this->extractor = $extractor;
    }

    #[Route('/game/play', name: 'web.game.play.view', methods: ['GET'])]
    public function __invoke(Game $game): Response | RedirectResponse
    {
        try {
            $playerDto = $this->extractor->player();
        } catch (PlayerNotFoundInTokenStorageException) {
            return $this->redirectToRoute('web.game.login.view');
        }

        $gameDto = $game->new('en', Type::byRole($playerDto->role()), WordCount::byLevel($playerDto->level()));

        return $this->render('@game/play.html.twig', [
            'player' => $playerDto,
            'game' => $gameDto,
        ]);
    }
}