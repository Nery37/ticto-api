<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\UserCheckIn;
use App\Presenters\UserCheckInPresenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class UserCheckInRepositoryEloquent.
 */
class UserCheckInRepositoryEloquent extends Repository implements UserCheckInRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return UserCheckIn::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return UserCheckInPresenter::class;
    }

    public function getSubordinatesCheckIns(?string $startDate = null, ?string $endDate = null, int $page = 1, int $perPage = 10): array
    {
        $managerId = auth('api')->id();
        $offset = ($page - 1) * $perPage;

        $totalQuery = "
            SELECT COUNT(*) as total
            FROM user_check_ins AS uci
            JOIN users AS u ON u.id = uci.user_id
            WHERE u.manager_id = :manager_id
        ";
        $bindings = ['manager_id' => $managerId];

        if ($startDate && $endDate) {
            $totalQuery .= " AND uci.created_at BETWEEN :start_date AND :end_date";
            $bindings['start_date'] = $startDate;
            $bindings['end_date'] = $endDate . ' 23:59:59';
        }
        $totalRecords = DB::selectOne($totalQuery, $bindings)->total;

        $query = "
            SELECT
                uci.id AS check_in_id,
                u.name AS employee_name,
                r.name AS role_name,
                TIMESTAMPDIFF(YEAR, u.birthdate, CURDATE()) AS age,
                m.name AS manager_name,
                DATE_FORMAT(uci.created_at, '%Y-%m-%d %H:%i:%s') AS timestamp
            FROM
                user_check_ins AS uci
            JOIN
                users AS u ON u.id = uci.user_id
            JOIN roles AS r ON r.id = u.role_id
            JOIN users AS m ON m.id = u.manager_id
            WHERE u.manager_id = :manager_id
        ";

        if ($startDate && $endDate) {
            $query .= " AND uci.created_at BETWEEN :start_date AND :end_date";
            $bindings['start_date'] = $startDate;
            $bindings['end_date'] = $endDate . ' 23:59:59';
        }

        $query .= " ORDER BY uci.created_at DESC LIMIT :per_page OFFSET :offset";
        $bindings['per_page'] = $perPage;
        $bindings['offset'] = $offset;

        $records = DB::select($query, $bindings);

        $totalPages = ceil($totalRecords / $perPage);

        return [
            'data' => $records,
            'current_page' => $page,
            'per_page' => $perPage,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
        ];
    }


}
