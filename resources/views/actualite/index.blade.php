
 @extends('layouts.master')

 @section('title','LRI | Liste des actualites')

@section('header_page')

      <h1>
        Actualite
        <small>Liste</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">actualite</a></li>
      </ol>

@endsection

@section('asidebar')
@component('components.sidebar',['active' => 'Actualites']) @endcomponent
@endsection

@section('content')


    <div class="row">
      <div class="col-md-12">
        <div class="box col-xs-12">
          <div class="container" style="padding-top: 30px">
          <div class="row" style="padding-bottom: 20px">
             <div class="box-header col-xs-9">
              <h3 class="box-title">Liste des actualites</h3>
            </div>
          </div>
          </div>
            
            <!-- /.box-header -->
            <div class="box-body">
           
              <div class="pull-right">
                <a href="{{url('actualites/create')}}" type="button" class="btn btn-block btn-success btn-lg"><i class="fa fa-plus"> Nouvel actualite</i></a>
              </div>
              
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Titre</th>
                  <th>Description</th>
                  <th>Date</th>
                  <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                  @foreach($actualites as $actualite)
                  <tr>
                    <td class="col-sm-1">{{$actualite->titre}}</td>
                    <td class="col-sm-3">{{$actualite->description}}</td>
                    <td class="col-sm-1">{{$actualite->created_at->toDateString()}}</td>
                    <td class="col-sm-1">
                      <div class="btn-group">
                <form action="{{ url('actualites/'.$actualite->id)}}" method="post"> 

                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                      <a href="{{ url('actualites/'.$actualite->id.'/details')}}" class="btn btn-info">
                        <i class="fa fa-eye"></i>
                      </a>
               
                      <a href="{{ url('actualites/'.$actualite->id.'/edit')}}" class="btn btn-default">
                        <i class="fa fa-edit"></i>
                      </a>
                
                      

                       <a href="#supprimer{{ $actualite->id }}Modal" role="button" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash-o"></i></a>
                      <div class="modal fade" id="supprimer{{ $actualite->id }}Modal" tabindex="-1" role="dialog" aria-labelledby="supprimer{{ $actualite->id }}ModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                    <!--   <h5 class="modal-title" id="supprimer{{ $actualite->id }}ModalLabel">Supprimer</h5> -->
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body text-center">
                                      Voulez-vous vraiment effectuer la suppression ? 
                                  </div>
                                  <div class="modal-footer">
                                      <form class="form-inline" action="{{ url('actualites/'.$actualite->id)}}"  method="POST">
                                          @method('DELETE')
                                          @csrf
                                      <button type="button" class="btn btn-light" data-dismiss="modal">Non</button>
                                          <button type="submit" class="btn btn-danger">Oui</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                      </form>
                    </div>
                    </td>
                  </tr>
                  @endforeach
                  
                 </tbody>
                <tfoot>
                <tr>
                  <th>Titre</th>
                  <th>Description</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        
      </div>
      
    </div>
 @endsection