jQuery(document).ready(function($){
        $('.select-special').select2();
        $('.experiences-crud-edit-service-btn').click(function(e){
            e.preventDefault()
            $('.experiences-crud-servtag-editor').val($(this).data('servtag'))
            $('.servtag-title').val($(this).data('title'))
            $('.servtag-content').val($(this).data('content'))
            $('.servtag-bussiness').val($(this).data('bussiness'))
            $('.servtag-datein').val($(this).data('datein'))
            $('.servtag-dateout').val($(this).data('dateout'))
            $('.experiences-crud-editor').slideToggle()
            setTimeout(function(){
                $('html, body').animate({
                    scrollTop: $("#experiences-crud-editor").offset().top
                }, 800);
            },400)
        });
        $('.experiences-crud-delete').click(function(e){
            e.preventDefault()
            if (confirm('¿Deseas eliminar esta experiencia?') == true) {
                $.post(experiences_crud.ajax_url,{action:"experiences_crud_servtag_delete",id:$(this).data('servtag'),uidd:$(this).data('uidd')},function(data){
                    console.log(data);
                    setTimeout('location.reload()',2000);
                });
            }
        });
        $('.experiences-crud-editor form').on('submit',function(){
            var $this = $(this);
            $.post(experiences_crud.ajax_url,$this.serialize(),function(data){
                console.log(data);
                setTimeout('location.reload()',2000)
                $this.trigger('reset');
                $this.closest('.experiences-crud-editor').slideUp();
            });
            return false;
        })
});