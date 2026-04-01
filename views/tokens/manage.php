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
                    <div class="panel-body panel-table-full">
                        <div class="panel-heading">
                           <?php echo _l('api_x_apps_tokens'); ?>
                        </div>
                         <?php render_datatable([
                            _l('table_tokens_id'),
                            _l('token_name'),
                            _l('token_value'),
                            _l('status'),
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
        <?php echo form_open(admin_url('api_x_apps/tokens/manage'), ['id' => 'token-form']); ?>
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
                        <?php echo render_input('token_name', 'token_name'); ?>
                        <?php echo render_input('token_value', 'token_value'); ?>
                        <?php echo render_textarea('description', 'description'); ?>
                        <?php echo render_select('status', [['id' => 1, 'name' => _l('active')], ['id' => 0, 'name' => _l('inactive')]], ['id', 'name'], 'status', 1); ?>
                        <?php echo render_datetime_input('expires_at', 'expires_at'); ?>
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
        initDataTable('.table-tokens', admin_url + 'api_x_apps/tokens/table', undefined, undefined, undefined, [0, 'desc']);
        appValidateForm($('#token-form'), { token_name: 'required' }, manage_token);
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
        $('#token-form')[0].reset();
        $('#token-form #id').val('');
    }

    function edit_token(invoker, id) {
        $('#token_modal').modal('show');
        $('.add-title').addClass('hide');
        $('.edit-title').removeClass('hide');
        $('#token-form #id').val(id);
        $('#token-form #token_name').val($(invoker).data('token_name'));
        $('#token-form #token_value').val($(invoker).data('token_value'));
        $('#token-form #description').val($(invoker).data('description'));
        $('#token-form #status').val($(invoker).data('status')).change();
        $('#token-form #expires_at').val($(invoker).data('expires_at'));
    }
</script>
</body>
</html>
