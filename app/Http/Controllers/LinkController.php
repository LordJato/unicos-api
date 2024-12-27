<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Repositories\LinkRepository;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function __construct(private readonly LinkRepository $linkRepository) {}

        /**
     * Display a Generated Link for Register.
     */
    public function registerLink(Request $request): JsonResponse
    {
        try {
            $data = $this->linkRepository->generateRegisterLink($request->all());

            return $this->responseSuccess($data, "Account fetched successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

}
