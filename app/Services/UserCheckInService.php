<?php

declare(strict_types=1);

namespace App\Services;

use App\Criteria\TodayCheckInsForUserCriteria;
use App\Enums\CheckInTypeEnum;
use App\Repositories\UserCheckInRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * UserCheckInService.
 */
class UserCheckInService extends AppService
{
    protected RepositoryInterface $repository;

    /**
     * @param UserCheckInRepository $repository
     */
    public function __construct(
        UserCheckInRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function createCheckIn(): mixed
    {
        try {
            DB::beginTransaction();

            $data['user_id'] = auth('api')->id();

            $lastCheckInTypeId = $this->repository
                ->where('user_id', $data['user_id'])
                ->latest('created_at')
                ->value('check_in_type_id');

            $data['check_in_type_id'] = ($lastCheckInTypeId === CheckInTypeEnum::CHECK_IN->value)
                ? CheckInTypeEnum::CHECK_OUT->value
                : CheckInTypeEnum::CHECK_IN->value;

            $checkIn = $this->create($data, true);

            DB::commit();
            return $this->repository->skipPresenter(false)->find($checkIn->id);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getSubordinatesCheckIns(?string $startDate, ?string $endDate, int $page = 1, int $perPage = 10): array
    {
        return $this->repository->getSubordinatesCheckIns($startDate, $endDate, $page, $perPage);
    }

    public function getUserCheckInsToday(): array
    {
        try {

            $queryBuilder = $this->repository
            ->resetCriteria()
            ->pushCriteria(app(TodayCheckInsForUserCriteria::class));

            return $queryBuilder->all();

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
