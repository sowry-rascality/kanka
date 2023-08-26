<?php

namespace App\Http\Controllers\Entity\Posts;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Http\Requests\EditPostVisibility;
use App\Models\Post;
use App\Models\Entity;

class VisibilityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity->child, 'edit', $post]);
        //$roles = $campaign->roles->where('is_public', false)->all();
        return view('entities.components.posts.visibility', [
            'campaign' => $campaign,
            'post' => $post,
            'entity' => $entity,
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(EditPostVisibility $request, Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity->child, 'edit', $post]);

        $post->update($request->all());

        return Response()->json(['test' => 'test', 'toast' => __('visibilities.toast'), 'icon' => $post->visibilityIcon('btn-box-tool')]);
    }

}
