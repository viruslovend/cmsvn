<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Page;
use Intervention\Image\Facades\Image;

class PageController extends BackendController
{
    protected $uploadPath;

    public function __construct()
    {
        parent::__construct();
        $this->uploadPath = public_path(config('cms.image.directory'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $onlyTrashed = FALSE;

        if (($status = $request->get('status')) && $status == 'trash')
        {
            $pages       = Page::onlyTrashed()->with('author')->latest()->paginate($this->limit);
            $pageCount   = Page::onlyTrashed()->count();
            $onlyTrashed = TRUE;
        }
        elseif ($status == 'published')
        {
            $pages       = Page::published()->with('author')->latest()->paginate($this->limit);
            $pageCount   = Page::published()->count();
        }
        elseif ($status == 'scheduled')
        {
            $pages       = Page::scheduled()->with('author')->latest()->paginate($this->limit);
            $pageCount   = Page::scheduled()->count();
        }
        elseif ($status == 'draft')
        {
            $pages       = Page::draft()->with('author')->latest()->paginate($this->limit);
            $pageCount   = Page::draft()->count();
        }
        elseif ($status == 'own')
        {
            $pages       = $request->user()->pages()->with('author')->latest()->paginate($this->limit);
            $pageCount   = $request->user()->pages()->count();
        }
        else
        {
            $pages       = Page::with('author')->latest()->paginate($this->limit);
            $pageCount   = Page::count();
        }

        $statusList = $this->statusList($request);

        return view("backend.page.index", compact('pages', 'pageCount', 'onlyTrashed', 'statusList'));
    }

    private function statusList($request)
    {
        return [
            'own'       => $request->user()->pages()->count(),
            'all'       => Page::count(),
            'published' => Page::published()->count(),
            'scheduled' => Page::scheduled()->count(),
            'draft'     => Page::draft()->count(),
            'trash'     => Page::onlyTrashed()->count(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Page $page)
    {
        return view('backend.page.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PageRequest $request)
    {
        $data = $this->handleRequest($request);

        $request->user()->page()->create($data);

        return redirect('/backend/page')->with('message', 'Your page was created successfully!');
    }

    private function handleRequest($request)
    {
        $data = $request->all();

        if ($request->hasFile('image'))
        {
            $image       = $request->file('image');
            $fileName    = $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = $image->move($destination, $fileName);

            if ($successUploaded)
            {
                $width     = config('cms.image.thumbnail.width');
                $height    = config('cms.image.thumbnail.height');
                $extension = $image->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                Image::make($destination . '/' . $fileName)
                    ->resize($width, $height)
                    ->save($destination . '/' . $thumbnail);
            }

            $data['image'] = $fileName;
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view("backend.page.edit", compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\pageRequest $request, $id)
    {
        $page     = Page::findOrFail($id);
        $oldImage = $page->image;
        $data     = $this->handleRequest($request);
        $page->update($data);

        if ($oldImage !== $page->image) {
            $this->removeImage($oldImage);
        }
        return redirect('/backend/page')->with('message', 'Your page was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::findOrFail($id)->delete();

        return redirect('/backend/page')->with('trash-message', ['Your page moved to Trash', $id]);
    }

    public function forceDestroy($id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        $page->forceDelete();

        $this->removeImage($page->image);

        return redirect('/backend/page?status=trash')->with('message', 'Your page has been deleted successfully');
    }

    public function restore($id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        $page->restore();

        return redirect()->back()->with('message', 'You page has been moved from the Trash');
    }

    private function removeImage($image)
    {
        if ( ! empty($image) )
        {
            $imagePath     = $this->uploadPath . '/' . $image;
            $ext           = substr(strrchr($image, '.'), 1);
            $thumbnail     = str_replace(".{$ext}", "_thumb.{$ext}", $image);
            $thumbnailPath = $this->uploadPath . '/' . $thumbnail;

            if ( file_exists($imagePath) ) unlink($imagePath);
            if ( file_exists($thumbnailPath) ) unlink($thumbnailPath);
        }
    }
}
