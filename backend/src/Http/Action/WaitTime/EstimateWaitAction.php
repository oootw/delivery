<?php

declare(strict_types=1);

namespace App\Http\Action\WaitTime;

use App\Application\WaitTime\Query\EstimateWait\EstimateWaitFetcher;
use App\Application\WaitTime\Query\EstimateWait\EstimateWaitQuery;
use App\Http\Response\ApiResponse;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Предварительная оценка времени ожидания до оформления заказа.
 * GET /venues/{venueId}/wait-estimate?type=delivery&units=3
 */
class EstimateWaitAction extends AbstractController
{
    public function __construct(
        private readonly EstimateWaitFetcher $estimateWait,
    ) {}

    #[Route('/venues/{venueId}/wait-estimate', name: 'app_estimate_wait', methods: ['GET'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $minutes = $this->estimateWait->fetch(
                new EstimateWaitQuery(
                    venueId: $venueId,
                    type: (string) $request->query->get('type', 'delivery'),
                    units: $request->query->getInt('units', 1),
                ),
            );

            return ApiResponse::success(['estimated_wait_minutes' => $minutes]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'wait-time/estimate',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
