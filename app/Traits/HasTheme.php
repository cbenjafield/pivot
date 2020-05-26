<?php

namespace App\Traits;

trait HasTheme
{
    protected function handleThemeData(array $data = [])
    {
        return array_merge([
            'website' => request('website'),
            'domain' => request('domain'),
        ], $data);
    }

    public function view($filename, array $data = [])
    {
        return view((request('website')->theme ?? 'default') . '.' . $filename, $this->handleThemeData($data));
    }
}