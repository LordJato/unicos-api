<?php

namespace App\Http\Controllers\v1;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Repositories\v1\LinkRepository;
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

            return $this->responseSuccess($data, "Generate Link successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

}
