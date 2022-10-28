
Route::get('list-posts', [CommentsController::class, 'listPosts']);

app\Http\Controllers\Api\CommentsController.php

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use App\Models\Posts; 
use Illuminate\Http\Request;

class CommentsController extends Controller
{

  //Question 1
  //Return a list of Top Posts ordered by their number of Comments.
  
  public function listPosts(): array
    {
		$posts = Posts::join('comments', 'comments.postId', 'posts.id')
				->select([
				   'posts.id as post_id', 'posts.title as post_title', 'posts.body as post_body', 
					DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.postId = posts.id) as total_number_of_comments')
				])->groupBy('posts.id')->get();

        return [
            'posts' => new CommentResource($posts)
        ];
    }
  
  
  //Question 2
  //Search API Create an endpoint that allows a user to filter the comments based on all the available fields. Your solution needs to be scalable.
  
  public function searchComments(Request $request): array
    {
		$commentRecords = Comments::select("*")
            ->when($f = request('search_text'), function ($query) use ($f) {
                $query->where(function ($query) use ($f) {
                    $query->where('name', 'like', '%' . $f . '%')
                        ->orWhere('email', 'like', '%' . $f . '%')
                        ->orWhere('body', 'like', '%' . $f . '%');
                });
            })
            ->get();

        return [
            'comments' => CommentResource::collection($commentRecords),
        ];
    }

}
