<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tw-mb-2 sm:tw-mb-4">
                    <a href="#" class="btn btn-primary" onclick="new_key(); return false;">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        <?php echo _l('new_key'); ?>
                    </a>
                </div>
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="panel-header">
                           <?php echo _l('api_x_apps_keys'); ?>
                        </div>
                         <?php render_datatable([
                            _l('table_keys_id'),
                            _l('table_keys_col1'),
                            _l('table_keys_col2'),
                            _l('options')
                        ], 'keys'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="key_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('keys/manage'), ['id' => 'key-form']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_key'); ?></span>
                    <span class="add-title"><?php echo _l('new_key'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_hidden('id'); ?>
                        <?php echo render_input('new_column_1', 'table_keys_col1'); ?>
                        <?php echo render_input('new_column_2', 'table_keys_col2'); ?>
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
        initDataTable('.table-keys', window.location.href + '/table', undefined, undefined, 'undefined');
        appValidateForm($('#key-form'), { new_column_1: 'required' }, manage_key);
    });

    function manage_key(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                $('.table-keys').DataTable().ajax.reload();
                alert_float('success', response.message);
            }
            $('#key_modal').modal('hide');
        });
        return false;
    }

    function new_key() {
        $('#key_modal').modal('show');
        $('.edit-title').addClass('hide');
        $('.add-title').removeClass('hide');
        $('#key-form').attr('action', '<?php echo admin_url('keys/manage'); ?>');
        $('#key-form #id').val('');
        $('#key-form #new_column_1').val('');
        $('#key-form #new_column_2').val('');
    }

    function edit_key(invoker, id) {
        $('#key_modal').modal('show');
        $('.add-title').addClass('hide');
        $('.edit-title').removeClass('hide');
        $('#key-form').attr('action', '<?php echo admin_url('keys/manage'); ?>');
        $('#key-form #id').val(id);
        $('#key-form #new_column_1').val($(invoker).data('col1'));
        $('#key-form #new_column_2').val($(invoker).data('col2'));
    }
</script>
</body>
</html>
