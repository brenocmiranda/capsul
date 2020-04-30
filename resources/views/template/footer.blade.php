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
  </script>

  @yield('support')
  
</body>
</html>
