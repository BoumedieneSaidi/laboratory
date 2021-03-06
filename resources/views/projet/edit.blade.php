@extends('layouts.master')

@section('title','LRI | Liste des projets')

@section('header_page')

      <h1>
        Projets
        <small>Modifier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li><a href="{{ url('projets')}}">Projets</a></li>
        <li class="active">Modifier</li>
      </ol>

@endsection

@section('asidebar')
@component('components.sidebar',['active' => 'Projets']) @endcomponent
 @endsection

@section('content')
     
  <div class="row" style="padding-top: 30px">
      <div class="col-xs-12">
        <div class="box">
            
          <div class="container col-xs-12">

            <form class="well form-horizontal" action="{{url('projets/'.$projet->id)}} " method="post"  id="contact_form" enctype="multipart/form-data">
              <input type="hidden" name="_method" value="PUT">
              {{ csrf_field() }}
              <fieldset>

                <!-- Form Name -->
                <legend><center><h2><b>Modifier projet</b></h2></center></legend><br>

                  <div class="form-group ">
                        <label class="col-xs-3 control-label">Intitulé</label>  
                        <div class="col-xs-9 inputGroupContainer">
                          <div style="width: 70%">
                            <input  name="intitule" class="form-control" value="{{ $projet -> intitule}}" type="text">
                          </div>
                        </div>
                  </div>  

                  <div class="form-group">
                      <label class="col-md-3 control-label">Résumé</label>
                      <div class="col-md-9 inputGroupContainer">
                        <div style="width: 70%">
                          <textarea class="form-control" name="resume" rows="3"> {{ $projet -> resume}}
                          </textarea>
                        </div>
                      </div>
                  </div>

                  <div class="form-group ">
                        <label class="col-xs-3 control-label">Type</label>  
                        <div class="col-xs-9 inputGroupContainer">
                          <div style="width: 70%">
                            <select name="type" class="form-control select">
                              <option>{{ $projet -> type}}</option>
                              <option>Poster</option>
                              <option>Article court</option>
                              <option>Article long</option>
                              <option>Publication(Revue)</option>
                              <option>Chapitre d'un livre</option>
                              <option>Livre</option>
                              <option>Brevet</option>
                            </select>
                          </div>
                        </div>
                  </div>

                  <div class="form-group ">
                        <label class="col-xs-3 control-label">Chef du projet</label>  
                        <div class="col-xs-9 inputGroupContainer">
                          <div style="width: 70%">
                            <select name="chef_id" class="form-control select2">
                              <option value="{{$projet->chef->id}}">{{$projet->chef->name}}</option>
                              @foreach($membres as $membre)
                              <option value="{{$membre->id}}">{{$membre->name}} {{$membre->prenom}}</option>
                               @endforeach
                            </select>
                          </div>
                        </div>
                  </div>  

                  <div class="form-group">
                    <label class="col-md-3 control-label">Membres (*)</label>
                    <div class="col-md-9 inputGroupContainer">
                      <div style="width: 70%">
                        <select name="membre[]" class="form-control select2 " multiple="multiple" data-placeholder="Selectionnez les Membres">
                          <option>
                             @foreach ($projet->users as $user) 
                              <option value="{{$user->id}}" selected >
                                  {{ $user->name }} {{ $user->prenom }}
                              </option>
                            @endforeach
                          </option>
                           @foreach($membres as $membre)
                              <option value="{{$membre->id}}">{{$membre->name}} {{$membre->prenom}}</option>
                           @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">Membres externes</label>
                    <div class="col-md-9 inputGroupContainer">
                      <div style="width: 70%">
                        <select name="contacts[]" class="form-control select2" multiple="multiple" data-placeholder="Selectionnez les Membres Externes">
                          <option>
                             @foreach ($projet->contacts as $contact) 
                              <option value="{{$contact->id}}" selected>
                                  {{ $contact->nom }} {{ $contact->prenom }}
                              </option>
                            @endforeach
                          </option>
                          <?php 
                          $allContacts = $contacts;
                          foreach($allContacts as $k => $contact){
                            foreach($projet->contacts as $selected){
                              if($contact->id == $selected->id){
                                unset($allContacts[$k]);
                              }
                            }
                          }
                        ?>
                         @foreach($allContacts as $contact)
                              <option value="{{$contact['id']}}">{{$contact['nom']}} {{$contact['prenom']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group ">
                        <label class="col-xs-3 control-label">Lien</label>  
                        <div class="col-xs-9 inputGroupContainer">
                          <div style="width: 70%">
                            <input  name="lien" value="{{ $projet -> lien}}"  class="form-control" placeholder="URL" type="url">
                          </div>
                        </div>
                  </div> 



                  <div class="form-group">
                      <label class="col-md-3 control-label">Détails</label>
                      <div class="col-md-9 inputGroupContainer">
                        <div style="width: 70%">
                          <input name="detail" type="file">
                        </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-md-3 control-label">Photo</label>
                      <div class="col-md-9 inputGroupContainer">
                        <div style="width: 70%">
                          <input name="photo" type="file" accept="image/*"> 
                        </div>
                      </div>
                  </div>

              </fieldset>

              <div class="row" style="padding-top: 30px; margin-left: 35%;">
              <button type="submit" href="{{url('projets')}}" class=" btn btn-lg btn-default"><i class="fa  fa-mail-reply"></i> &nbsp;Annuler</button>
               <button type="submit" class=" btn btn-lg btn-primary"><i class="fa fa-check"></i> Modifier</button> 
                  </div>
            </form>
          </div>
         </div><!-- /.container -->
       </div>
      </div>
    
  @endsection