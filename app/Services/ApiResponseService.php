<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponseService
{

    /**
     * Return a successful JSON response
     *
     * @param mixed  $data The data to return in the response
     * @param string $message the success message
     * @param int $status the HTTP status Code
     *
     * @return \Illuminate\Http\JsonResponse The JSON response.
     *
     */
    public static function success($data = null, $message = 'Operation successful', $status = 200): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'message' => trans($message),
                'data' => $data,
            ],
            $status
        );
    }


    /**
     * Return an error JSON response.
     *
     * @param string $message The error message.
     * @param int $status The HTTP status code.
     * @param mixed $data The data to return in the response.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public static function error($message = 'Operation failed', $status = 400, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => trans($message),
            'data' => $data,
        ], $status);
    }

    /**
     * Return a paginated JSON response.
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator The paginator instance.
     * @param string $message The success message.
     * @param int $status The HTTP status code.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */

    public static function paginated(LengthAwarePaginator $paginator, $resourceClass, $message = 'Operation successful', $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => trans($message),
            'data' => $resourceClass::collection($paginator->items()),
            'pagination' => [
                'total' => $paginator->total(),
                'count' => $paginator->count(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage(),
            ],
        ], $status);
    }
}
