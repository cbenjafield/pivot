<?php

namespace App\Traits;

use Image;
use App\Media;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadsMedia
{
    public function upload(UploadedFile $file)
    {
        if($this->fileIsImage($file)) {
            return $this->uploadImage($file);
        }

        return $this->uploadFile($file);
    }

    protected function fileIsImage(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();

        return !! in_array($extension, [
            'jpg', 'jpeg',
            'png',
            'gif'
        ]);
    }

    protected function uploadImage(UploadedFile $file)
    {
        $image = Image::make($file);

        $image->resize(1500, null, function (Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $extension = $file->getClientOriginalExtension();

        if(in_array($extension, ['jpeg'])) {
            $extension = 'jpg';
        }

        $imageContents = (string) $image->encode($extension, 75);
        $filename = Str::uuid() . ".{$extension}";

        Storage::disk('media')->put($filename, $imageContents);

        \Tinify\setKey(env('TINIFY_KEY'));
        
        $source = \Tinify\fromBuffer(Storage::disk('media')->get($filename));

        Storage::disk('media')->put($filename, (string) $source->toBuffer());

        return Media::create([
            'user_id' => auth()->id(),
            'site_id' => $this->id,
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'disk' => 'media',
            'size' => Storage::disk('media')->size($filename),
            'type' => $file->getMimeType(),
            'width' => $image->width(),
            'height' => $image->height(),
        ]);
    }

    protected function uploadFile(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . ".{$extension}";

        Storage::disk('media')->putFileAs(null, $file, $filename);

        return Media::create([
            'user_id' => auth()->id(),
            'site_id' => $this->id,
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'disk' => 'media',
            'size' => Storage::disk('media')->size($filename),
            'type' => $file->getMimeType(),
        ]);
    }
}