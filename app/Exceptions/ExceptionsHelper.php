<?php

namespace App\Exceptions;

use App\Exceptions\CustomExceptions\TaskBadRequestHttpException;
use Illuminate\Http\Response;
use App\Exceptions\CustomExceptions\NoContentHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Exceptions\CustomExceptions\ProjectBadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ExceptionsHelper
{
    /**
     * @param $request
     * @param $exception
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function apiExceptions($request, $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Model not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'Route not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return response()->json([
                'error' => 'Access denied.'
            ], Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof NoContentHttpException) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                 'error' => 'Method not allowed.'
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof ProjectBadRequestHttpException) {
            return response()->json([
                'error' => 'Title and description are required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($exception instanceof TaskBadRequestHttpException) {
            return response()->json([
                'error' => 'Description is required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $exception);
    }
}