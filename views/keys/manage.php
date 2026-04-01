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
                    <div class="panel-body panel-table-full">
                        <div class="panel-heading">
                           <?php echo _l('api_x_apps_keys'); ?>
                        </div>
                         <?php render_datatable([
                            _l('table_keys_id'),
                            _l('key_name'),
                            _l('key_value'),
                            _l('status'),
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
        <?php echo form_open(admin_url('api_x_apps/keys/manage'), ['id' => 'key-form']); ?>
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
                        <?php echo render_input('key_name', 'key_name'); ?>
                        <?php echo render_input('key_value', 'key_value'); ?>
                        <?php echo render_textarea('description', 'description'); ?>
                        <?php echo render_select('status', [['id' => 1, 'name' => _l('active')], ['id' => 0, 'name' => _l('inactive')]], ['id', 'name'], 'status', 1); ?>
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
        initDataTable('.table-keys', admin_url + 'api_x_apps/keys/table', undefined, undefined, undefined, [0, 'desc']);
        appValidateForm($('#key-form'), { key_name: 'required' }, manage_key);
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
        $('#key-form')[0].reset();
        $('#key-form #id').val('');
    }

    function edit_key(invoker, id) {
        $('#key_modal').modal('show');
        $('.add-title').addClass('hide');
        $('.edit-title').removeClass('hide');
        $('#key-form #id').val(id);
        $('#key-form #key_name').val($(invoker).data('key_name'));
        $('#key-form #key_value').val($(invoker).data('key_value'));
        $('#key-form #description').val($(invoker).data('description'));
        $('#key-form #status').val($(invoker).data('status')).change();
    }
</script>
</body>
</html>
