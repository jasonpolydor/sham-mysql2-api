<?php

namespace App\Traits;

use App\AttachmentHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Plank\Mediable\Media;
use MediaUploadException;
use MediaUploader;
use Plank\Mediable\Mediable;
use Session;

trait MediaFiles
{
    /**
     * To display files
     * @param Request $request
     * @param $Id
     * @param int $is_preview
     * @param null $allowedActions
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attachment(Request $request, $Id, $is_preview = 0, $allowedActions = null)
    {
        $uModelName = $this->getModelName($request)['model'];
        $modelClass = 'App\\'.$uModelName;

        $relatedMedias = $modelClass::find($Id);
        $medias = $relatedMedias->media()->get();

        return view('partials.medias', compact('medias','uModelName','Id', 'is_preview', 'allowedActions'));
    }

    public function preview($mediaId) {
        $media = Media::find($mediaId);
        if ($media!=null) {
            $data = file_get_contents($media->getAbsolutePath());
            $fileObj = AttachmentHelper::fromBlob($data, $media->filename.'.'.$media->extension);
            return response()->file($fileObj->pathToFile);
        }
    }

    /**
     * To upload file
     * @param Request $request
     * @param $Id
     * @param null $model
     * @return array
     */
    public function attach(Request $request, $Id, $model = null)
    {
        if($model != null){
            $uModelName = $model;
        }else{
            $name = $this->getModelName($request);
            $uModelName = $name['model'];
        }

        $modelClass = 'App\\'.$uModelName;

        $relatedMedias = $modelClass::find($Id);
        $returns = [];

        if (!is_null($request->request->get('attachment'))) {
            foreach($request->request->get('attachment') as $file) {
                $stream = fopen($file['value'], 'r');
                try {
                    //get current disk where the file will be uploaded
                    $disk = 'uploads';

                    $temp = explode('.', $file['title']);
                    $last = array_pop($temp);
                    $temp = array(implode('.', $temp), $last);

                    $name = $temp[0];
                    $ext = $temp[1];

                    $mediaFile = Media::forPathOnDisk($disk, $uModelName.'/'.$file['title'])->first();
                    if(is_null($mediaFile)) {
                        $filename = $name;
                    }else{
                        $filename = $name.'-'.rand(1, 10);
                    }

                    $media = MediaUploader::fromSource($stream)
                        ->useFilename($filename)
                        ->toDestination($disk, $uModelName)
                        ->setStrictTypeChecking(true)
                        // pass the callable
                        ->beforeSave(function (Media $model) use ($request, $ext) {
                            $model->setAttribute('extension', $ext);
                            $model->setAttribute('comment', $request->input('comment'));
                            $model->setAttribute('extrable_id', $request->input('Extrable_Id'));
                            $model->setAttribute('extrable_type', $request->input('Extrable_Type'));
                        })
                        ->upload();

                    $relatedMedias->attachMedia($media, $uModelName);

                } catch (MediaUploadException $e) {
                    Session::put('error', $e->getMessage());
                }

                $returns[] = $media;
            }
        }

        return $returns;
    }

    public function attachSingleFile(Request $request, $Id, $filefield)
    {
        $name = $this->getModelName($request);

        $uModelName = $name['model'];
        $modelClass = 'App\\'.$uModelName;

        $relatedMedias = $modelClass::find($Id);
        $returns = [];

        if($request->hasFile( $filefield) && $request->file($filefield)->isValid()){

            $fileToProcess = $request->file($filefield);
            $stream = fopen($fileToProcess, 'r');
            try {
                //get current disk where the file will be uploaded
                $disk = 'uploads';

                //take only filename and not extension
                $temp = explode('.', $fileToProcess->getClientOriginalName());
                $name = $temp[0];
                $ext = $temp[1];

                $media =  MediaUploader::fromSource($request->file($filefield))
                    ->toDestination($disk, $uModelName)
                    ->upload();

            } catch (MediaUploadException $e) {
                Session::put('error', $e->getMessage());
            }

            //dump($relatedMedias);die;

            //to sync mediable table with media table on upload
            $relatedMedias->attachMedia($media, $uModelName);
            //$relatedMedias->syncMedia($media, $modelName);

            $returns[] = $media;
        }
        return $returns;
    }

    public function syncSingleFile(Request $request, $Id, $filefield)
    {
        $name = $this->getModelName($request);

        $uModelName = $name['model'];
        $modelClass = 'App\\'.$uModelName;

        $relatedMedias = $modelClass::find($Id);
        $returns = [];

        if($request->hasFile( $filefield) && $request->file($filefield)->isValid()){

            $fileToProcess = $request->file($filefield);
            $stream = fopen($fileToProcess, 'r');
            try {
                //get current disk where the file will be uploaded
                $disk = 'uploads';

                //take only filename and not extension
                $temp = explode('.', $fileToProcess->getClientOriginalName());
                $name = $temp[0];
                $ext = $temp[1];

                $media =  MediaUploader::fromSource($request->file($filefield))
                    ->toDestination($disk, $uModelName)
                    ->upload();

            } catch (MediaUploadException $e) {
                Session::put('error', $e->getMessage());
            }

            //dump($relatedMedias);die;

            //to sync mediable table with media table on upload
            $relatedMedias->syncMedia($media, $uModelName);

            $returns[] = $media;
        }
        return $returns;
    }

    /**
     * remove media
     * @param Request $request
     * @param $pivot_mediable_id
     * @param $is_preview
     * @param $mediaId
     * @return mixed
     */
    public function detach(Request $request, $pivot_mediable_id, $mediaId)
    {
        $name = $this->getModelName($request);
        $modelClass = 'App\\'.$name['model'];

        $relatedMedias = $modelClass::find($pivot_mediable_id);

        $media = Media::find($mediaId);
        $media->delete();
        $relatedMedias->detachMedia($media);

        Session::put('success', 'media removed Successfully!');

        return Redirect::back();
    }

    /**
     * to download files
     * @param $pivot_mediable_id
     * @param $is_preview
     * @param $mediaId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($pivot_mediable_id, $is_preview = 0, $mediaId)
    {
        $media = Media::find($mediaId);
        return response()->download($media->getAbsolutePath());
    }

    /**
     * get model from routeName
     * @param $request
     * @return array
     */
    private function getModelName($request){
        $routeName = $request->route()->getName();
        $uModelName = Str::singular(ucfirst(explode(".", $routeName)[0]));
        return [ 'route' => $routeName , 'model' => $uModelName];
    }
}
