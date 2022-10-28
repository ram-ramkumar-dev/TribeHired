app\Http\Resources\CommentResource.php

<?php

namespace App\Http\Resources;

use App\Models\Comments;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'postId' => $this->postId,
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'body' => $this->body,
        ];
    }
}
