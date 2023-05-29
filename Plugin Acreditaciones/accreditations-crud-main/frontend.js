jQuery(document).ready(function($){
        $('.select-special').select2();
        $('.accreditations-crud-edit-service-btn').click(function(e){
            e.preventDefault()
            $('.accreditations-crud-servtag-editor').val($(this).data('servtag'))
            $('.servtag-title').val($(this).data('title'))
            $('.servtag-content').val($(this).data('content'))
            $('.servtag-bussiness').val($(this).data('bussiness'))
            $('.servtag-datein').val($(this).data('datein'))
            //$('.servtag-dateout').val($(this).data('dateout'))
            $('.accreditations-crud-editor').slideToggle()
            setTimeout(function(){
                $('html, body').animate({
                    scrollTop: $("#accreditations-crud-editor").offset().top
                }, 800);
            },400)
        });
        $('.accreditations-crud-delete').click(function(e){
            e.preventDefault()
            if (confirm('¿Deseas eliminar esta Acreditación?') == true) {
                $.post(accreditations_crud.ajax_url,{action:"accreditations_crud_servtag_delete",id:$(this).data('servtag'),uidd:$(this).data('uidd')},function(data){
                    console.log(data);
                    setTimeout('location.reload()',2000);
                });
            }
        });
        $('.accreditations-crud-editor form').on('submit',function(){
            var $this = $(this);
            var form_data = new FormData(this);
            $.ajax({
                url: accreditations_crud.ajax_url,
                type: 'post',
                data: form_data,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                    setTimeout('location.reload()',2000)
                    //$this.trigger('reset');
                    $this.closest('.accreditations-crud-editor').slideUp();
                }
            });
            return false;
        })
});