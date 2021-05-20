<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://assets.pagar.me/pagarme-js/4.8/pagarme.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
<script src="https://assets.pagar.me/checkout/1.1.0/checkout.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<!-- Template JS File -->
<script src="{{ asset('public/js/moment-business.js') }}"></script>
<script src="{{ asset('public/js/scripts.js') }}"></script>
<script src="{{ asset('public/js/jquery.countdown.js') }}"></script>
<script src="{{ asset('public/js/custom.js') }}"></script>
<script src="{{ asset('public/js/stisla.js') }}"></script>
<script src="{{ asset('public/js/jquery.mask.js') }}"></script>
<script src="{{ asset('public/js/page/index.js') }}"></script>
<script src="{{ asset('public/js/datatables.js') }}"></script>
<script src="{{ asset('public/js/jquery.toast.js') }}"></script>
<script src="{{ asset('public/js/page/bootstrap-modal.js') }}"></script>
<script src="{{ asset('public/js/page/modules-ion-icons.js') }}"></script>
<script src="{{ asset('public/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('public/modules/dropzonejs/min/dropzone.min.js') }}"></script>
<script src="{{ asset('public/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('public/modules/codemirror/lib/codemirror.js') }}"></script>
<script src="{{ asset('public/modules/codemirror/mode/javascript/javascript.js') }}"></script>
<script src="{{ asset('public/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('public/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('public/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('public/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('public/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>

@if(Auth::check())
<script type="text/javascript">
  function image(input){
    if(input.files && input.files[0]){
      var reader = new FileReader();
      reader.onload = function (oFREvent){
        $('#'+input.id).prev('#PreviewImage').attr('src', oFREvent.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function dataPtBr(data){
    var aux = data.split('-');
    data = aux[2]+'/'+aux[1]+'/'+aux[0];
    return data;
  }

  // Função leitura de todas notificações
  function read(input){
    $.ajax({
      url: '{{url("notificationsRead")}}/'+input.id,
      type: 'GET',
      success: function(data){
        window.document.location = $(input).attr("data-url");
      }
    });
  }

  $(document).ready(function (){
    // Função para logout do usuário
    $('.logout').on('click', function(){
      if (confirm('Tem certeza que deseja sair?')){
        window.document.location = "{{ route('logout') }}";
      }
    });

    /*
    // Função de carregamento de todas notify
    $.ajax({
      url: '{{ route("notificacoes.all") }}',
      type: 'GET',
      success: function(data){
        if(data){
          $.each(data, function(count, dados){
            $('.notNotify').addClass('d-none');
            $('.notification-toggle').addClass('beep');
            $('.dropdown-list-content').append('<a href="javascript:void(0)" class="dropdown-item dropdown-item-unread" data-url="'+dados.data.link+'" id="'+dados.notifiable_id+'" onClick="read(this)"> <div class="dropdown-item-icon bg-primary text-white"> <i class="'+dados.data.icon+'"></i> </div> <div class="dropdown-item-desc font-weight-bold"> '+dados.data.subtitulo+' <div class="time text-primary">'+dados.data.date+'</div> </div> </a>');
          });
        }
      }
    }); 
    // Função de atualização das notificações
    setInterval(function(){
      $.ajax({
        url: '{{ route("notificacoes") }}',
        type: 'GET',
        success: function(data){
          if(data.success != false){
            if(data){
              $.each(data, function(count, dados){
                $('.notNotify').addClass('d-none');
                $('.notification-toggle').addClass('beep');
                $('.dropdown-list-content').append('<a href="javascript:void(0)" class="dropdown-item dropdown-item-unread" data-url="'+dados.data.link+'" id="'+dados.notifiable_id+'" onClick="read(this)"> <div class="dropdown-item-icon bg-primary text-white"> <i class="'+dados.data.icon+'"></i> </div> <div class="dropdown-item-desc font-weight-bold"> '+dados.data.subtitulo+' <div class="time text-primary">'+dados.data.date+'</div> </div> </a>');
                $.toast({
                  heading: dados.data.titulo,
                  text: dados.data.message,
                  hideAfter: false,
                  icon: 'success',
                  hideAfter: 5000,
                  position : 'bottom-right',
                  showHideTransition: 'slide'
                });
              });
            }
          }
        }
      }); 
    }, 2000);
    // Função leitura de todas notificações
    $('.readAll').on('click', function(e){
      $.ajax({
        url: '{{ route("notificacoes.read.all") }}',
        type: 'GET',
        success: function(data){
          $('.notNotify').removeClass('d-none');
          $('.notification-toggle').removeClass('beep');
          $('.dropdown-list-content .dropdown-item-unread').remove();
        }
      }); 
    });*/

  });
</script>
@endif

@yield('support')

</body>
</html>
