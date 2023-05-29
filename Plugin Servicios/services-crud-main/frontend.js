jQuery(document).ready(function($){
    //$(window).on('load',function(){
        $('.select-special').select2();
        $('.services-crud-edit-service-btn').click(function(e){
            e.preventDefault()
            if ($(this).data('categories') !== '') {
                var arrrCats = []
                if ($(this).data('categories').toString().indexOf(',') > -1) {
                    $.each($(this).data('categories').split(","), function(i,e){
                        arrrCats.push(e);
                    });
                }else{
                    arrrCats.push($(this).data('categories'));
                }

                $('.servtag-categories').val(arrrCats);
                $('.servtag-categories').trigger('change');
            }
            $('.services-crud-servtag-editor').val($(this).data('servtag'))
            $('.servtag-title').val($(this).data('title'))
            $('.servtag-content').val($(this).data('content'))
            $('.services-crud-editor').slideToggle()
            setTimeout(function(){
                $('html, body').animate({
                    scrollTop: $("#services-crud-editor").offset().top
                }, 800);
            },400)
        });
        $('.services-crud-delete').click(function(e){
            e.preventDefault()
            if (confirm('¿Deseas eliminar este servicio?') == true) {
                $.post(services_crud.ajax_url,{action:"services_crud_servtag_delete",id:$(this).data('servtag'),uidd:$(this).data('uidd')},function(data){
                    console.log(data);
                    setTimeout('location.reload()',2000);
                });
            }
        });
        $('.services-crud-editor form').on('submit',function(){
            var $this = $(this);
            var form_data = new FormData(this);
            $.ajax({
                url: services_crud.ajax_url,
                type: 'post',
                data: form_data,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                    setTimeout('location.reload()',2000)
                    $this.trigger('reset');
                    $this.closest('.services-crud-editor').slideUp();
                }
            });
            /*$.post(,$this.serialize(),function(data){
                console.log(data);
                setTimeout('location.reload()',2000)
                $this.trigger('reset');
                $this.closest('.services-crud-editor').slideUp();
            });*/
            return false;
        })
    //});
});