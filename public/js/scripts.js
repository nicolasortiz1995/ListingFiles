/* Initializer Script  */

(function ($) {  
  $("body").dore();
  
})(jQuery);

function formChangePassword(){ 

  $("#passwordLength").hide();
  $("#repeatPassword").hide();

  if($('input[name=password]').val().length <= 3 || $('input[name=repeatPassword]').val().length <= 3 ){
    $("#passwordLength").show();
    return;
  }

  if($('input[name=password]').val() != $('input[name=repeatPassword]').val()){
    $("#repeatPassword").show();
    return;
  }
   
  Swal.fire({
    title: 'CONFIRMACIÓN',
    text: "¿Seguro que desea enviar este formulario?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#00365a',
    cancelButtonColor: '#184f90',
    confirmButtonText: 'Si, seguro!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      
      var data = {
        'password':$('input[name=password]').val(),
        'repeatPassword':$('input[name=repeatPassword]').val()
      }

      var route='auth/changePasswordLogin';
      controlador(route,data,'POST',function(data){
          Swal.fire({ 
            icon: 'success',
            title: 'Contraseña actualizada',
            showConfirmButton: false,
            timer: 1500
          });

          setTimeout(() => { 
            $.post("auth/signOut", function(htmlexterno){
              $(location).attr('href','/auth/login');
            });
          }, 1600); 
         
      });

    }
  })

}

function controlador(route, datos, metodo,callback){

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    data: {
      "datos": datos
    },
    type: metodo,
    dataType: "json",
    async: true,
    url: "/"+route
  })
  .done(function(respuesta) {
    if (respuesta) {
      typeof callback === 'function' && callback(respuesta);
    } else {
      console.log(respuesta.error);
    }
  })
  .fail(function(jqXHR, textStatus) {
    // console.log("responseJSON",jqXHR.responseJSON);
    console.log("responseText",jqXHR.responseText);   
  });
}

function loadingFiles(dir){  
  
  $("#showfiles").empty();
  $("#breadcrumb-files").empty();
  $("#loading-spinner").show();
  $("#showfiles").hide();

  $("#inputSearch").val('');

  controlador('loadingFiles',{'dir':dir},'GET',function(data){
      
      console.log(data); 
      $("#loading-spinner").hide();

      var html = ''; 
      html = paintFiles(data.data); 

      var breadcrumb ='';
      breadcrumb = paintBreadcrumb(data.breadcrumb); 

      $("#breadcrumb-files").empty().append(breadcrumb);      
      $("#showfiles").empty().append(html);
      $("#showfiles").show();
  });

}


function searchFiles(){
  
  $("#breadcrumb-files").empty();
  $("#showfiles").empty();
  $("#loading-spinner").show();
  $("#showfiles").hide();

  var inputSearch = $("#inputSearch").val();

  if(inputSearch != ''){
    controlador('searchFiles',{'buscar':inputSearch},'GET',function(data){
        
        console.log(data);
        $("#loading-spinner").hide();

        var html = ''; 
        html = paintFiles(data); 

        $("#showfiles").empty().append(html);
        $("#showfiles").show();
    });    
  }else{
    loadingFiles()
  }

}


function uploadfiles(){

  var formData = new FormData();
  $inputFile = $('#inputFile');
  formData.append('inputFile', $inputFile[0].files[0]);
  formData.append('dirFile', $("#selectUbiFile").val() );

  Swal.fire({
    title: 'Subiendo archivo!',
    html: 'Espere por favor.', 
    timerProgressBar: true,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading()
    }
  }) 

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  }); 

  $.ajax({
    data: formData,
    type: 'POST',
    dataType: "json",
    async: true,
    cache: false,
    contentType: false,
    processData: false,
    url: "/uploadfiles"
  })
  .done(function(respuesta) {

    console.log(respuesta);
    
    swal.close(); 
    Swal.fire({
      icon: 'success',
      title: 'Archivo subido!',
      text: 'Su archivo fue subido correctamente',
      confirmButtonColor: '#00365a',
      allowOutsideClick: false
    })
    closeUploadfiles();
    loadingFiles();
  })
  .fail(function(jqXHR, textStatus) { 
    swal.close();
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'No se pudo subir archivo!',
      confirmButtonColor: '#00365a',
      allowOutsideClick: false
    })
    console.log("responseText",jqXHR.responseText);   
  });

}

function typeFileIcon(file){

  var ruta='img/files/file.png';

   switch(file){

        case 'dir':
          ruta='img/files/folder.png';
        break;

        case 'txt':
        case 'docm':
        case 'dot':
        case 'dotx':
          ruta='img/files/texto.png';
        break;
 
        case 'pdf':
          ruta='img/files/pdf.png';
        break;

        case 'doc':
        case 'docx':
          ruta='img/files/word.png';
        break;
        
        case 'xls':
        case 'xlsx':
        case 'xlsm':
        case 'xlt':
        case 'xltx':
          ruta='img/files/excel.png';
        break; 

        case 'pps':
        case 'ppsx':
        case 'ppsm':
        case 'ppt':
        case 'pptx':
        case 'pptm':
        case 'pot':
        case 'potx':
          ruta='img/files/powerpoint.png';
        break;

        case 'mp3':
        case 'wav':
        case 'aiff':
        case 'wma':
        case 'wmv':
        case 'ogg':
        case 'flac':
        case 'alac':
        case 'dsd':
        case 'midi':
        case 'ra':
        case 'cda':
        case 'aac':
        case 'ac3':
        case 'm3u':
          ruta='img/files/mpeg.png';
        break;

        case 'jpeg':
        case 'jpg':
        case 'png':
        case 'gif':
        case 'bmp':
        case 'ico':
        case 'svg':
        case 'webp':
        case 'eps':
        case 'ai':
        case 'id':
        case 'pic':
        case 'tiff':
        case 'heic':
        case 'raw':
        case 'nef':
        case 'wmf':
        case 'dwg':
          ruta='img/files/imagen.png';
        break;

        case 'avi':
        case 'asf':
        case 'divx':
        case 'mov':
        case 'mp4':
        case 'mpg':
        case 'mkv':
        case 'wmv':
        case 'wpl':
        case 'mov':
        case 'webm':
        case 'wob':
        case 'flv':
        case 'swf':
          ruta='img/files/video.png';
        break;

        default:
          ruta='img/files/file.png';
        break; 
   }

   return ruta;

}

function paintBreadcrumb(folder){
    var html = '';

    console.log(folder);

    for (let index = 0; index < folder.length; index++) {
         var element = folder[index];
         if(element !== '' && index < (folder.length - 1) ){
           html += `
             <li class="breadcrumb-item">
                 <a onclick="openFolder('${element.ruta}','','')" href="javascript:void(0)">${element.item}</a>
             </li> 
           `; 
         }

         if(element !== '' && index == (folder.length - 1)){
          html += `<li class="breadcrumb-item active" aria-current="page">${element.item}</li>`;
         }
    } 

    return html;
}

function paintFiles(file){
  var html = '';

  if(file.length > 0){
    for (let index = 0; index < file.length; index++) {
      var element = file[index];
      html += `
              <div class="col-xxl-4 col-xl-6 col-12">
                <div class="card d-flex flex-row mb-4 media-thumb-container">
                    <a class="d-flex align-self-center media-thumbnail-icon"
                        href="javascript:void(0)"> 
                        <img alt="Profile Picture" src="${urlBase}${typeFileIcon(element.extension)}" />
                    </a>
                    <div class="d-flex flex-grow-1 min-width-zero">
                        <div
                            class="card-body align-self-center d-flex flex-column justify-content-between min-width-zero" style="padding:5px !important;width: 20px !important;">`;
                            if(element.extension !== 'dir'){
      html +=               `<a href="javascript:void(0)" class="w-100">`;
                            }else{
      html +=               `<a onclick="openFolder('${element.rutaDir}','${element.basename}','${element.extension}')" href="javascript:void(0)" class="w-100">`;                              
                            }

      html +=                 `<p class="list-item-heading mb-1 truncate">${element.filename}</p>
                            
                                      <p class="mb-1 text-muted text-small w-100 truncate" data-toggle="tooltip"
                                    data-placement="bottom" title="${element.rutaView}">${element.rutaView}</p>
                            </a>
                        </div>
                        <div class="pl-1 align-self-center">`;

                        if(element.extension !== 'dir'){ 
                        if(validTypeFileView(element.extension))
      html +=              `<a  onclick="viewFiles('${urlBase}${element.ruta}','${element.basename}','${element.extension}')" href="javascript:void(0)" title="Visualizar" style="padding-right:5px"> <i class="simple-icon-eye font-icon"></i></a>`;

      html +=              `<a  href="${urlBase}${element.ruta}" download="${element.basename}" title="Descargar"> <i class="simple-icon-cloud-download font-icon"></i></a>`;

                        if(rolBase != 'Consultor')
      html +=              `<a  onclick="deleteFiles('${element.ruta}','${element.basename}','${element.extension}')" href="javascript:void(0)" title="Borrar" style="padding-right:5px"> <i class="simple-icon-trash font-icon"></i></a>`;
                        }

      html +=         `</div>
                    </div>
                </div>
            </div>
          `;
    }
     html += `
           <script type="text/javascript"> 
              $(document).ready(function(){  
                  $('[data-toggle="tooltip"]').tooltip()
              });
          </script>
      `;
  }else{
    html += `
      <div class="col-xxl-12 col-xl-12 col-12 text-center">
        <h5 class="card-title">No se encontró resultados</h5>
      </div>
    `;
  }

  return html;

}

function validTypeFileView(file){
    
   switch(file){

        case 'txt': 
          ruta=true;
        break;
 
        case 'pdf':
          ruta=true;
        break; 

        case 'mp3':
        case 'wav':
        case 'aiff':
        case 'wma':
        case 'wmv':
        case 'ogg':
        case 'flac':
        case 'alac':
        case 'dsd':
        case 'midi':
        case 'ra':
        case 'cda':
        case 'aac':
        case 'ac3':
        case 'm3u':
          ruta=true;
        break;

        case 'jpeg':
        case 'jpg':
        case 'png':
        case 'gif':
        case 'bmp':
        case 'ico':
        case 'svg':
        case 'webp':
        case 'eps':
        case 'ai':
        case 'id':
        case 'pic':
        case 'tiff':
        case 'heic':
        case 'raw':
        case 'nef':
        case 'wmf':
        case 'dwg':
          ruta=true;
        break;

        case 'avi':
        case 'asf':
        case 'divx':
        case 'mov':
        case 'mp4':
        case 'mpg':
        case 'mkv':
        case 'wmv':
        case 'wpl':
        case 'mov':
        case 'webm':
        case 'wob':
        case 'flv':
        case 'swf':
          ruta=true;
        break;

        default:
          ruta=false;
        break; 
   }

   return ruta;

}

function openFolder(rutafolder,basename,extension){
   console.log(rutafolder); 
   $("[data-toggle='tooltip']").tooltip('hide');
   loadingFiles(rutafolder);
}

function viewFiles(rutafile,basename,extension){

  //Mostrar modal
  $('#iframeModalDownloadFiles').attr('src', rutafile);

  $('#btnModalDownloadFiles').attr('href', rutafile);
  $('#btnModalDownloadFiles').attr('download', basename);

  $('#ModalViewFiles').modal({backdrop: 'static', keyboard: false})
  $("#ModalViewFiles").modal("show");

}

function deleteFiles(rutafile,basename,extension){

   Swal.fire({
     title: 'Estas seguro de borrar el archivo?',
     text: "No podrás revertir esto.!",
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#00365a',
     cancelButtonColor: '#184f90',
     confirmButtonText: 'Si, seguro!',
     cancelButtonText: 'Cancelar'
   }).then((result) => {
     if (result.isConfirmed) {
       
       var data = {
         'rutafile':rutafile,
         'basename':basename,
         'extension':extension
       }

       var route='deletefiles';
       controlador(route,data,'POST',function(data){

          if(data.success){
            Swal.fire({ 
              icon: 'success',
              title: 'Su archivo ha sido eliminado.',
              showConfirmButton: false,
              timer: 1500
            });

            loadingFiles();
          }else{

            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'No se pudo eliminar el archivo!',
              confirmButtonColor: '#00365a',
              allowOutsideClick: false
            })

          }
           
          
       }); 
     }
   })

}

function closeViewFiles(){
 
  //Cerrar modal
  $('#iframeModalDownloadFiles').attr('src', '');

  $('#btnModalDownloadFiles').attr('href', '');
  $('#btnModalDownloadFiles').attr('download', '');

  $("#ModalViewFiles").modal("hide");

}

function closeUploadfiles(){
 
  //Cerrar modal 
  $("#inputFile").val(null);

  $(".custom-file-label").html('Subir archivo');

  $("#ModalUploadfiles").modal("hide");

}

function onLabelInputFile(){
 
  let filenames = [];
  let files = document.getElementById("inputFile").files;

  if (files.length > 1) {
    filenames.push("Total Archivos (" + files.length + ")");
  } else {
    for (let i in files) {
      if (files.hasOwnProperty(i)) {
        filenames.push(files[i].name);
      }
    }
  }
  $(".custom-file-label").html(filenames.join(","));

}

function viewModalUploadfiles(){
  
  controlador('listDirFiles',null,'GET',function(data){
       
      $('#selectUbiFile').empty();
      if (data.length > 0) {
          $("#selectUbiFile").empty(); 
          for (var i = 0; i < data.length; i++) {
              $("#selectUbiFile").append("<option value='" + data[i] + "'>" + data[i] + "</option>");
          }
      }

      //mostrar modal 
      $("#ModalUploadfiles").modal("show");

  });   

}