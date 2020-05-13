<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CreatesFromRequest
{
    /**
     * Get the model's relationship to the user.
     * 
     * @return string
     */
    protected static function getUserRelationshipMethod()
    {
        return Str::plural(strtolower(class_basename(static::class)));
    }

    /**
     * Create a new model instance from the user's request,
     * then redirect them to the new created resource.
     * 
     * @param  mixed  $request
     * @return \Illuminate\Http\Response
     */
    public static function createFromUserRequest($request)
    {
        $relationship = static::getUserRelationshipMethod();

        $model = auth()->user()
                            ->$relationship()
                            ->create(static::fillableRequestAttributes($request));
        
        return $model->redirect()->with('success', 'Successfully created.');
    }

    /**
     * Specify the redirection logic for the model.
     * 
     * @return \Illuminate\Http\Response
     */
    protected function redirect()
    {
        $key = $this->{$this->primaryKey};

        return redirect()
                    ->route(static::getUserRelationshipMethod() . '.show', $key);
    }

    /**
     * Update the model instance from the user's request,
     * then redirect them back to the show method.
     * 
     * @param  mixed  $request
     * @return \Illuminate\Http\Response
     */
    public function updateFromUserRequest($request)
    {
        $this->update(static::fillableRequestAttributes($request));

        return $this->redirect()
                        ->with('success', 'Successfully updated.');
    }

}