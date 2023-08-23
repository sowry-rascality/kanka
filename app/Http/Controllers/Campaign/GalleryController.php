<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Img;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageFocus;
use App\Http\Requests\Campaigns\GalleryImageFolderStore;
use App\Http\Requests\Campaigns\GalleryImageStore;
use App\Http\Requests\Campaigns\GalleryImageUpdate;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Campaign\GalleryService;
use Illuminate\Support\Arr;

class GalleryController extends Controller
{
    protected GalleryService $service;

    public function __construct(GalleryService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
        $this->service = $service;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        /*if (!$campaign->superboosted()) {
            return view('gallery.unsuperboosted')
                ->with('campaign', $campaign);
        }*/

        $folder = null;
        $folderId = request()->get('folder_id');
        if (!empty($folderId)) {
            $folder = Image::where('is_folder', '1')->where('id', $folderId)->firstOrFail();
        }

        $images = $campaign->images()->with('user')
            ->imageFolder($folderId)
            ->defaultOrder()
            ->paginate(50);

        return view('gallery.index', compact('campaign', 'images', 'folder'))
            ->with('galleryService', $this->service->campaign($campaign)->user(auth()->user()));
    }

    public function search(Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $name = trim(request()->get('q', null));
        $images = Image::where('name', 'like', "%{$name}%")
            ->defaultOrder()
            ->take(50)
            ->get();

        return view('gallery.images', compact(
            'images',
            'campaign',
        ));
    }

    /**
     * Uploading multiple images in the gallery
     * @param GalleryImageStore $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(GalleryImageStore $request, Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $images = $this->service
            ->campaign($campaign)
            ->store($request);

        $body = [];
        foreach ($images as $image) {
            $body[] = view('gallery._image')
                ->with('campaign', $campaign)
                ->with('image', $image)
                ->render();
        }

        return response()->json([
            'success' => true,
            'images' => $body,
            'campaign' => $campaign,
            'storage' => $this->service->storageInfo(),
        ]);
    }

    /**
     * Called when adding an image from the text editor
     * @param GalleryImageStore $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function ajaxUpload(GalleryImageStore $request, Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $images = $this->service
            ->campaign($campaign)
            ->store($request);
        $image = Arr::first($images);

        return response()->json(Img::resetCrop()->url($image->path));
    }

    /**
     * @param Image $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        $folders = $this->service->campaign($campaign)->folderList();

        return view('gallery.edit', compact('image', 'folders', 'campaign'));
    }

    /**
     * @param StoreImageFocus $request
     * @param Image $image
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function saveFocus(StoreImageFocus $request, Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        $added = $this->service
            ->campaign($campaign)
            ->image($image)
            ->saveFocusPoint($request);

        $params = [];
        if (!empty($image->folder_id)) {
            $params = ['folder_id' => $image->folder_id];
        }

        return redirect()->route('campaign.gallery.index', [$campaign] + $params)
            ->with('success', __('campaigns/gallery.focus.' . ($added ? 'updated' : 'removed')));
    }

    /**
     * @param GalleryImageUpdate $request
     * @param Image $image
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(GalleryImageUpdate $request, Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        $originalFolderID = $image->folder_id;
        $this->service
            ->campaign($campaign)
            ->image($image)
            ->update($request->only('name', 'folder_id', 'visibility_id'));

        $params = [];
        if ($image->is_folder) {
            $params = ['folder_id' => $image->id];
        } elseif ($originalFolderID != $image->folder_id) {
            $params = ['folder_id' => $originalFolderID];
        } elseif (!empty($image->folder_id)) {
            $params = ['folder_id' => $image->folder_id];
        }
        $params['campaign'] = $campaign;

        $key = $image->isFolder() ? 'folder' : 'success';
        return redirect()->route('campaign.gallery.index', $params)
            ->with('success', __('campaigns/gallery.update.' . $key));
    }

    /**
     * @param Image $image
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        $options = [$campaign];
        if ($image->folder_id) {
            $options['folder_id'] = $image->folder_id;
        }
        $this->service->campaign($campaign)->image($image)->delete();

        $key = $image->isFolder() ? 'folder' : 'success';
        return redirect()->route('campaign.gallery.index', $options)
            ->with('success', __('campaigns/gallery.destroy.' . $key, ['name' => $image->name]));
    }

    /**
     * Create a new folder
     */
    public function folder(GalleryImageFolderStore $request, Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $folder = $this->service
            ->campaign($campaign)
            ->createFolder($request);

        $params = [$campaign];
        if (!empty($folder->folder_id)) {
            $params['folder_id'] = $folder->folder_id;
        }

        return redirect()
            ->route('campaign.gallery.index', $params);
    }
}
