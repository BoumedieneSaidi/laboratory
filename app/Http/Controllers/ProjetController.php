<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\projetRequest;
use App\Projet;
use App\User;
use App\Contact;
use Auth;
use App\ProjetUser;
use App\ProjetContact;
use App\Parametre;
use Illuminate\Http\UploadedFile;

class ProjetController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //permet de lister les articles
    public function index(){
        $projets = Projet::all();
        $labo =  Parametre::find('1');
        // $membres = Projet::find($id)->users()->orderBy('name')->get();

        return view('projet.index' , ['projets' => $projets] ,['labo'=>$labo]);

    }

    public function details($id)
    {
        $labo =  Parametre::find('1');
        $projet = Projet::find($id);
        $membres = $projet->users()->orderBy('name')->get();
        $contacts = $projet->contacts()->orderBy('nom')->get();

        return view('projet.details')->with([
            'projet' => $projet,
            'membres'=>$membres,
            'contacts'=>$contacts,
            'labo'=>$labo,
        ]);;
    }

    //affichage de formulaire de creation d'articles
    public function create()
    {
        $labo =  Parametre::find('1');

        if( Auth::user()->role->nom == 'admin')
        {
            $membres = User::all();
            $projet = Projet::all();
            $contacts = Contact::all();
            return view('projet.create', ['membres' => $membres,'contacts'=>$contacts],['labo'=>$labo]);
        }
        else{
            return view('errors.403',['labo'=>$labo]);
        }
    }


    public function store(projetRequest $request){

        $projet = new Projet();
        $labo =  Parametre::find('1');

        if($request->hasFile('detail')){

            $file = $request->file('detail');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/uploads/projet'),$file_name);
            $projet->detail = '/uploads/projet/'.$file_name;
        }


        if($request->hasFile('photo')) {
            $file = $request->file('photo');
            $file_name = 'photo' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/uploads/projet/photo'), $file_name);
            $projet->photo = 'uploads/projet/photo/' . $file_name;

        }
        else{
            $projet->photo = 'uploads/images/projet.png';
        }

        $projet->intitule = $request->input('intitule');
        $projet->resume = $request->input('resume');
        $projet->type = $request->input('type');
        $projet->partenaires = $request->input('partenaires');
        $projet->lien = $request->input('lien');
        $projet->chef_id = $request->input('chef_id');



        $projet->save();

        $members =  $request->input('membre');
        foreach ($members as $key => $value) {
            $projet_user = new ProjetUser();
            $projet_user->projet_id = $projet->id;
            $projet_user->user_id = $value;
            $projet_user->save();

        }

        $contacts =  $request->input('contacts');
        if($contacts) {
            foreach ($contacts as $key => $value) {
                $projet_contact = new ProjetContact();
                $projet_contact->projet_id = $projet->id;
                $projet_contact->contact_id = $value;
                $projet_contact->save();
            }
        }
        return redirect('projets');


    }

    //récuperer un article puis le mettre dans le formulaire
    public function edit($id){

        $projet = Projet::find($id);
        $membres = User::all();
        $contacts = Contact::all();
        $labo =  Parametre::find('1');

        $this->authorize('update', $projet);

        return view('projet.edit')->with([
            'projet' => $projet,
            'membres' => $membres,
            'contacts'=>$contacts,
            'labo'=>$labo,
        ]);;

    }

    //modifier et inserer
    public function update(projetRequest $request , $id){

        $projet = Projet::find($id);
        $labo =  Parametre::find('1');

        if($request->hasFile('detail')){

            $file = $request->file('detail');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/uploads/projet'),$file_name);
            $projet->detail = '/uploads/projet/'.$file_name;

        }

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $file_name = 'photo' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/uploads/projet/photo'), $file_name);
            $projet->photo = 'uploads/projet/photo/' . $file_name;
        }

        $projet->intitule = $request->input('intitule');
        $projet->resume = $request->input('resume');
        $projet->type = $request->input('type');
        $projet->partenaires = $request->input('partenaires');
        $projet->lien = $request->input('lien');
        $projet->chef_id = $request->input('chef_id');

        $projet->save();

        $members =  $request->input('membre');
        $projet_user = ProjetUser::where('projet_id',$id);
        $projet_user->delete();

        foreach ($members as $key => $value) {
            $projet_user = new ProjetUser();
            $projet_user->projet_id = $projet->id;
            $projet_user->user_id = $value;
            $projet_user->save();

        }

        $contacts =  $request->input('contacts');
        $projet_contacts = ProjetContact::where('projet_id',$id);
        $projet_contacts->delete();
        if($contacts){
            foreach ($contacts as $key => $value) {
                $projet_contact = new ProjetContact();
                $projet_contact->projet_id = $projet->id;
                $projet_contact->contact_id = $value;
                $projet_contact->save();
            }
        }

        return redirect('projets');

    }
    //supprimer un article
    public function destroy($id){

        $projet = Projet::find($id);

        $this->authorize('delete', $projet);

        $projet->delete();
        return redirect('projets');

    }

}