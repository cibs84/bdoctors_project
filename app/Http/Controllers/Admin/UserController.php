<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Specialization;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = User::findOrFail($id);

        $specializations = Specialization::all();

        $data = [
            'user' => $user,
            'specializations' => $specializations
        ];

        return view('admin.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->getValidationRules());

        $form_data = $request->all();

        $user_to_update = User::findOrFail($id);

        // Gestione immagine:
        // se l'immagine è dichiarata nel $form_data
        if(isset($form_data['image'])) {
            // Calcello dal disco l'immagine vecchia se già essa esiste
            if($user_to_update->photo) {
                Storage::delete($user_to_update->photo);
            }
            // faccio l'upload del nuovo file $img_path
            $img_path = Storage::put('users_photo', $form_data['image']);
            // popolo $form_data con l'immagine
            $form_data['photo'] = Storage::url($img_path);
        }

        // Condizioni per lo slug
        if($form_data['name'] !== $user_to_update->name) {
            $form_data['slug'] = $this->getFreeSlugFromTitle($form_data['name']);
        } else {
            $form_data['slug'] = $user_to_update->slug;
        }

        // Condizioni per la remove-image
        if(isset($form_data['remove-image'])) {
            if($user_to_update->photo) {
                Storage::delete($user_to_update->photo);
            }

            $form_data['photo'] = null;
        }

        $user_to_update->update($form_data);

        // Condizioni per aggiungere specializzazioni all'user
        if(isset($form_data['specializations'])) {
            $user_to_update->specializations()->sync($form_data['specializations']);
        } else {
            $user_to_update->specializations()->sync([]);
        }

        return redirect()->route('admin.home', ['user' => $user_to_update->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_to_delete = User::findOrFail($id);

        if($user_to_delete->photo) {
            Storage::delete($user_to_delete->photo);
        }

        $user_to_delete->specializations()->sync([]);
        $user_to_delete->delete();

        return redirect()->route('guest');
    }

    // VALIDATIONS
    protected function getValidationRules() {
        return [
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'curriculum' => 'nullable|max:3000',
            'address' => 'required|max:60',
            'specializations' => 'required|exists:specializations,id',
            'photo' => 'mimes:jpg,jpeg,png,gif,webp,svg|max:1024|nullable',
            'phone_number' => 'nullable|max:30',
            'service' => 'nullable|max:500'
        ];
    }

    // Genera uno slug univoco da una stringa
    protected function getFreeSlugFromTitle($name) {
        // Assegnare lo slag
        $slug_to_save = Str::slug($name, '-');
        $slug_base = $slug_to_save;

        // Verificare se lo slag esiste nel database
        $existing_slug_user = User::where('slug', '=', $slug_to_save)->first();

        // Finchè non si trova uno slag libero, si appende un numero allo slag base -1, -2, ecc...
        $counter = 1;
        while($existing_slug_user) {
            // Si crea un nuovo slug con $counter
            $slug_to_save = $slug_base . '-' . $counter;

            // Verificare se lo slag esiste nel database
            $existing_slug_user = User::where('slug', '=', $slug_to_save)->first();

            $counter++;
        }

        return $slug_to_save;
    }
}
