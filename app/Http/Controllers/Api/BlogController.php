<?php

namespace App\Http\Controllers\Api;

use App\Services\BlogService;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogEditRequest;
use App\Http\Requests\BlogLikeRequest;
use App\Http\Requests\BlogListRequest;

class BlogController extends Controller
{
    public function create(BlogService $blogservice,BlogRequest $blogRequest){

        $blogData = $blogRequest->validated();
        $isBlogCreated = $blogservice->createBlog($blogData);
        $response = $isBlogCreated->getData(true);
        return response()->json($response,$response['code']);
    }
    public function edit(BlogService $blogservice,BlogEditRequest $blogEditRequest){

        $blogData = $blogEditRequest->validated();
        $isBlogUpdated = $blogservice->editBlog($blogData);
        $response = $isBlogUpdated->getData(true);
        return response()->json($response,$response['code']);
    }

    public function list(BlogService $blogservice,BlogListRequest $blogListRequest){

        $userData = $blogListRequest->validated();
        $blogList = $blogservice->blogList($userData);
        $response = $blogList->getData(true);
        return response()->json($response,$response['code']);
    }

    public function like(BlogService $blogservice,BlogLikeRequest $blogLikeRequest){

        $blogId = $blogLikeRequest->blogid;
        $likeBlog = $blogservice->blogLike($blogId);
        $response = $likeBlog->getData(true);
        return response()->json($response,$response['code']);
    }
    public function delete(BlogService $blogservice,BlogLikeRequest $blogLikeRequest){

        $blogData = $blogLikeRequest->validated();
        $deleteBlog = $blogservice->deleteBlog($blogData);
        $response = $deleteBlog->getData(true);
        return response()->json($response,$response['code']);
    }
}
