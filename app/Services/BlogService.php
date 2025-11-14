<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogService
{

    public function createBlog($data)
    {

        try {
            $blogId = 0;
            DB::transaction(function () use ($data, &$blogId) {

                $path = null;
                if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $image = $data['image'];
                    $path = $image->store('blogs', 'public');
                }

                $blog = Blog::create([
                    'title' => $data['title'],
                    'description' => $data['description'] ?? "",
                    'blog_image' => $path,
                    'user_id' => $data['user_id'],
                    'created_at' => getCurrentDateTime(),
                    'updated_at' => getCurrentDateTime(),
                ]);

                if ($blog) {
                    $blogId = $blog->id;
                } else {
                    throw new \Exception('Blog creation failed');
                }
            });

            return response()->json([
                'code'  => 200,
                'message' => 'Blog Created successfully',
                'blogId' => $blogId
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                'message' => 'Something went wrong: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function editBlog($data)
    {
        try {

            DB::transaction(function () use ($data) {

                $loginUserId = auth::user()->id;

                $blog = Blog::where('id', $data['blogid'])
                    ->where('user_id', $loginUserId)
                    ->first();

                if (!$blog) {
                    throw new \Exception('Blog not found or you are not authorized.');
                }

                $path = $blog->blog_image;
                if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $image = $data['image'];
                    Storage::disk('public')->delete($blog->blog_image);
                    $path = $image->store('blogs', 'public');
                }

                $updateBlog = [
                    'title' => $data['title'] ?? $blog->title,
                    'description' => $data['description'] ?? $blog->description,
                    'blog_image' => $path,
                    'updated_at' => getCurrentDateTime(),
                ];
                $blog->update($updateBlog);
            });
            return response()->json([
                'code'  => 200,
                'message' => 'Blog Updated successfully',
                'blogId' => $data['blogid']
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                'message' => 'Something went wrong: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function blogList($data)
    {
        try {

            $page = $data['page'] ?? 1;
            $search = $data['search_text'] ?? "";
            $mostLikeFilter = $data['most_like'] ?? 0;

            \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($page) {
                return $page;
            });
            $blogs = Blog::with('user:id,name,email')
                ->withCount('likes')
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->when($mostLikeFilter == true, function ($query) {
                    $query->orderBy('likes_count', 'desc');
                }, function ($query) {
                    $query->orderBy('id', 'desc');
                })
                ->paginate(50);
            if ($blogs) {
                $blogs->getCollection()->transform(function ($blog) {

                    return [
                        'id'          => $blog->id,
                        'title'       => $blog->title,
                        'description' => $blog->description,
                        'user'        => $blog->user,
                        'image_url'   => $blog->image_url,
                        'blog_like'   => $blog->likes_count,
                    ];
                });
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'Blogs fetched successfully',
                    'current_page' => $blogs->currentPage(),
                    'per_page' => $blogs->perPage(),
                    'total' => $blogs->total(),
                    'data' => $blogs->items(),
                ]);
            } else {
                throw new \Exception('No Blog Found');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                'message' => 'Something went wrong: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function blogLike($blogId)
    {
        try {
            $result = auth()->user()->likedBlogs()->toggle($blogId);
            $status = !empty($result['attached'])
                ? 'Blog liked successfully'
                : (!empty($result['detached']) ? 'Blog unliked successfully' : 'No action performed');

            return response()->json([
                'code' => 200,
                'message' => $status,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                'message' => 'Something went wrong: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function deleteBlog($blogData)
    {
        try {
            $loginUserId = Auth::user()->id;
            DB::transaction(function () use ($blogData, $loginUserId) {
                $blog = Blog::where('id', $blogData['blogid'])
                    ->where('user_id', $loginUserId)
                    ->first();

                if (!$blog) {
                    throw new \Exception('Blog not found or you are not authorized!! You can only delete your own blog.');
                }
                $blog->likes()->detach();
                $blog->delete();
            });
            return response()->json([
                'code' => 200,
                'message' => 'Blog deleted successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                'message' => 'Something went wrong: ' . $th->getMessage(),
            ], 400);
        }
    }
}
