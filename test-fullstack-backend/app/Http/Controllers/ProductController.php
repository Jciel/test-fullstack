<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

    public function index(): JsonResponse
    {
        try {
            return response()->json($this->productService->listAll(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function create(Request $req): JsonResponse
    {
        try {
            $this->validate($req, [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'price' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if (!$req->file('image')->isValid()) {
                return response()->json(['message' => 'Image is not valid'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            return response()->json($this->productService->createProduct(
                $req->input('name'),
                $req->input('description'),
                $req->input('price'),
                $req->file('image'),
            ), Response::HTTP_OK);
        } catch (UnprocessableEntityHttpException $e){
            return $this->error($e->getMessage(), [], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
