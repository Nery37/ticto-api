<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\AppHelper;
use App\Exceptions\CustomExceptionInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $service;

    protected $validator;

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return $this->successWithOrWithoutContentResponse(
                $this->service->all(
                    intval($request->query->get('limit', 15)),
                    AppHelper::toBoolean($request->query->get('paginate', true)) ?? true,
                    $request->query->get('sortBy', 'id'),
                    $request->query->get('sortDir', 'asc')
                )
            );
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

        /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexWhitoutPagination(): JsonResponse
    {
        try {
            return $this->successWithOrWithoutContentResponse(
                $this->service->allWithoutPagination()
            );
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int|string $id): JsonResponse
    {
        try {
            return $this->successWithOrWithoutContentResponse($this->service->find($id));
        } catch (\Exception $exception) {
            if ($exception instanceof ModelNotFoundException) {
                return $this->successResponse([
                    'data' => null
                ]);
            }

            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidatorException
     */
    public function store(Request $request): JsonResponse
    {
        try {
            if ($this->validator) {
                $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            }
            return $this->successCreatedResponse($this->service->create($request->all()));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     *
     * @throws ValidatorException
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            if ($this->validator) {
                $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            }
            return $this->successResponse($this->service->update($request->all(), $id));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        try {
            return $this->successResponse($this->service->restore($id));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return $this->successNoContentResponse();
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function destroyByUuid(string $uuid): JsonResponse
    {
        try {
            $this->service->deleteByUuid($uuid);
            return $this->successNoContentResponse();
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function showByUuid(string $uuid): JsonResponse
    {
        try {
            return $this->successCreatedResponse($this->service->findByUuid($uuid));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * @param Request $request
     * @param         $uuid
     *
     * @return JsonResponse
     */
    public function updateByUuid(Request $request, $uuid): JsonResponse
    {
        try {
            if ($this->validator) {
                $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            }
            return $this->successResponse($this->service->updateByUuid($request->all(), $uuid));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception);
        }
    }

    /**
     * @param array $body
     *
     * @return JsonResponse
     */
    protected function successResponse(array $body = []): JsonResponse
    {
        return response()->json($body);
    }

    /**
     * @param array $body
     *
     * @return JsonResponse
     */
    protected function successCreatedResponse(array $body = []): JsonResponse
    {
        return response()->json(
            $body,
            ResponseAlias::HTTP_CREATED
        );
    }

    /**
     * @return JsonResponse
     */
    protected function successNoContentResponse(): JsonResponse
    {
        return response()->json([], ResponseAlias::HTTP_NO_CONTENT);
    }

    /**
     * @param array $body
     *
     * @return JsonResponse
     */
    protected function successWithOrWithoutContentResponse(array $body = []): JsonResponse
    {
        if (!empty($body)) {
            return $this->successResponse($body);
        }

        return $this->successNoContentResponse();
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = ''): JsonResponse
    {
        if ('' == $message) {
            $message = 'not_found';
        }

        return response()->json(
            [
                'message' => $message
            ],
            ResponseAlias::HTTP_NOT_FOUND
        );
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function internalServerErrorResponse(string $message = ''): JsonResponse
    {
        if ('' == $message) {
            $message = 'Internal server error';
        }

        return response()->json(
            [
                'message' => $message,
            ],
            ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * @param array|string $stringOrArray
     *
     * @return JsonResponse
     */
    protected function badRequestResponse(array|string $stringOrArray = ''): JsonResponse
    {
        if (empty($stringOrArray)) {
            $stringOrArray = 'Invalid parameters';
        }

        return response()->json(
            [
                'message' => $stringOrArray,
            ],
            ResponseAlias::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function tooManyRequestsResponse(string $message = ''): JsonResponse
    {
        if ('' == $message) {
            $message = 'Exceeded limit attempts';
        }

        return response()->json(
            [
                'message' => $message,
            ],
            ResponseAlias::HTTP_TOO_MANY_REQUESTS
        );
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function unauthorizedResponse(string $message = ''): JsonResponse
    {
        if ('' == $message) {
            $message = 'Missing or invalid authorization.';
        }

        return response()->json(
            [
                'message' => $message,
            ],
            ResponseAlias::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @param string     $message
     * @param int|string $code
     *
     * @return JsonResponse
     */
    protected function undefinedErrorResponse(CustomExceptionInterface|\Exception $e): JsonResponse
    {
        $statusCode = 500;
        $data = [
            'slug' => 'internal_error',
            'title' => 'Ops!',
            'description' => $e->getMessage(), // TODO: Quando for subir isso, lembrar de retornar mensagem generica.
        ];

        if ($e instanceof CustomExceptionInterface) {
            $data = [
                'slug' => $e->getSlug(),
                'title' => $e->getTitle(),
                'description' => $e->getDescription(),
            ];
            $statusCode = $e->getStatusCode();
        }

        Log::error(
            $data['slug'],
            [
                'message' => !empty($e->getMessage()) ? $e->getMessage() : $e->getDescription(),
                'error_trace' => $e->getTraceAsString(),
            ]
        );

        return response()->json($data, $statusCode);
    }
}
