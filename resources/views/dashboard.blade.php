@section('title','Dashboard')
@extends('layouts.app')
@section('content')

<style>
    .font-icon{
        font-size: 25px;
    }

    .ventana_pdf .modal-dialog{
        top: 0px;
        width:80%;
        height: 80%;
        border:0;
    }

</style>

<div class="container-fluid library-app">
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <h1>Dashboard</h1>
                <div class="text-zero top-right-button-container">   

                    <a href="javascript:void(0)" class="btn btn-primary btn-lg top-right-button mr-1" onclick="viewModalUploadfiles()">Subir archivo</a>

                    <!-- <div class="btn-group">
                        <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                            <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                <input type="checkbox" class="custom-control-input" id="checkAll">
                                <span class="custom-control-label"></span>
                            </label>
                        </div>  
                        <button type="button"
                            class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                        </div>  
                    </div>-->
                </div> 
            </div>
            
            <div class="mb-2">
                <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions"
                    role="button" aria-expanded="true" aria-controls="displayOptions">
                    Mostrar buscador
                    <i class="simple-icon-arrow-down align-middle"></i>
                </a>
                <div class="collapse d-md-block" id="displayOptions">
                    <div class="d-block d-md-inline-block">
                        <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top" style="width: 300px !important">
                            <input placeholder="Buscar..." id="inputSearch" style="width: 100% !important" onkeyup="searchFiles()">
                        </div>
                    </div>
                </div> 
            </div>

            <div class="separator mb-5"></div>
        </div>
    </div>

    <div class="row"> 
        <div class="col-12 col-xl-12 list disable-text-selection" data-check-all="checkAll">
            
            <div class="col-12 mt-3 mb-5 text-center" id="loading-spinner" style="display: none">
                <div class="spinner-grow " role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                <ol class="breadcrumb pt-0" id="breadcrumb-files">
                    
                </ol>
            </nav>

            <div class="row" id="showfiles" style="display: none"> 

                <!-- Listado de archivos cargado por Ajax--> 

            </div> 
            
        </div>
    </div>

    <!-- Modal para ver archivo --> 
    <div class="modal fade" id="ModalViewFiles" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Visualizar adjunto</h5>
                    <a  href="#" class="close" onclick="closeViewFiles()">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                
                <div id="">
                    <iframe id="iframeModalDownloadFiles" style="width: 100%; height: 545px" ></iframe>
                </div>
                
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" onclick="closeViewFiles()" >Close</a>
                    <a href="#" download="#" title="Descargar" class="btn btn-primary" id="btnModalDownloadFiles"> Descargar </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal para subit archivo --> 
    <div class="modal fade" id="ModalUploadfiles" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Subir archivo</h5>
                    <a  href="#" class="close" onclick="closeUploadfiles()">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                
                <form action="javascript:uploadfiles()">
                    <div class="card mb-4">
                        <div class="card-body"> 
                            
                            <label class="form-group has-float-label mt-3 mb-3">
                                <span>Ubicación del archivo</span>
                                <select class="form-control" id="selectUbiFile" data-width="100%" required>                                 
                                </select>
                            </label>
                            
                            <div class="input-group mt-4 mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="simple-icon-cloud-upload"></i></span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputFile" name="inputFile" onchange="onLabelInputFile()" required>
                                    <label class="custom-file-label" for="inputFile">Subir archivo</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <a href="#" class="btn btn-secondary" onclick="closeUploadfiles()" >Close</a>
                        <button href="javascript:void(0)" class="btn btn-primary btn-lg top-right-button mr-1">Subir archivo</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
 
<script type="text/javascript">
    let urlBase = '{{ URL::asset("/") }}';
    let rolBase = '{{ auth()->user()->rol }}';

    $(document).ready(function(){ 
        loadingFiles();
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

@endsection

