<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tw-mb-2 sm:tw-mb-4">
                    <a href="#" class="btn btn-primary" onclick="new_token(); return false;">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        <?php echo _l('new_token'); ?>
                    </a>
                </div>
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="panel-header">
                           <?php echo _l('api_x_apps_tokens'); ?>
                        </div>
                         <?php render_datatable([
                            _l('table_tokens_id'),
                            _l('table_tokens_col1'),
                            _l('table_tokens_col2'),
                            _l('options')
                        ], 'tokens'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="token_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('tokens/manage'), ['id' => 'token-form']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_token'); ?></span>
                    <span class="add-title"><?php echo _l('new_token'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_hidden('id'); ?>
                        <?php echo render_input('new_column_1', 'table_tokens_col1'); ?>
                        <?php echo render_input('new_column_2', 'table_tokens_col2'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function() {
        initDataTable('.table-tokens', window.location.href + '/table', undefined, undefined, 'undefined');
        appValidateForm($('#token-form'), { new_column_1: 'required' }, manage_token);
    });

    function manage_token(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                $('.table-tokens').DataTable().ajax.reload();
                alert_float('success', response.message);
            }
            $('#token_modal').modal('hide');
        });
        return false;
    }

    function new_token() {
        $('#token_modal').modal('show');
        $('.edit-title').addClass('hide');
        $('.add-title').removeClass('hide');
        $('#token-form').attr('action', '<?php echo admin_url('tokens/manage'); ?>');
        $('#token-form #id').val('');
        $('#token-form #new_column_1').val('');
        $('#token-form #new_column_2').val('');
    }

    function edit_token(invoker, id) {
        $('#token_modal').modal('show');
        $('.add-title').addClass('hide');
        $('.edit-title').removeClass('hide');
        $('#token-form').attr('action', '<?php echo admin_url('tokens/manage'); ?>');
        $('#token-form #id').val(id);
        $('#token-form #new_column_1').val($(invoker).data('col1'));
        $('#token-form #new_column_2').val($(invoker).data('col2'));
    }
</script>
</body>
</html>
