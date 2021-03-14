<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Rest;

use App\Dictionary\Application\Request\WordRequest;
use App\Dictionary\Application\Service\WordsFinder;
use App\Shared\Application\Response\ResponseFactory;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IgnoreAnnotation("OA\Info")
 * @IgnoreAnnotation("OA\SecurityScheme")
 * @IgnoreAnnotation("OA\Get")
 * @IgnoreAnnotation("OA\Response")
 * @IgnoreAnnotation("OA\Parameter")
 * @IgnoreAnnotation("OA\Schema")
 *
 * @OA\Info(title="Dictionary API", version="1.0.0")
 */
final class WordAction extends AbstractController
{
    /**
     * @OA\Get(
     *     path="/dictionary/words/{language}/word",
     *     description="Get word",
     *     @OA\Response(response="default", description="Get word by parameters"),
     *     @OA\Parameter(
     *          name="language",
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *         name="mask",
     *         in="query",
     *         description="Search words where second symbol is 'e' => `.e.*`. Search words where start from `t` symbol and size 4 letters => `t...`. Search any words that containt with 4 letters => `....`",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     )
     * )
     */
    public function __invoke(WordRequest $request, WordsFinder $wordsFinder): Response
    {
        $response = new ResponseFactory($request->format());

        $words = $wordsFinder->findByRequest($request);
        if ($words->count()) {
            return $response->success($words->jsonSerialize());
        }

        return $response->failed('Word is not found');
    }
}