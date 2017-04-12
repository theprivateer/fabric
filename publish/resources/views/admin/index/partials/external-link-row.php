<script id="external-link-row" type="text/x-handlebars-template">
    <tr id="item-{{ uuid }}">
        <td class="sort-handle">
            <i class="icon-arrows"></i>
            <input type="hidden" name="items[{{ uuid }}][sort]" role="sort-order">
        </td>
        <td class="btn-column text-muted"><small>External</small></td>
        <td>
            <input name="items[{{ uuid }}][label]" type="text" class="form-control" placeholder="Label" style="margin-bottom: 5px;">
            <input name="items[{{ uuid }}][external_link]" type="text" class="form-control" placeholder="URL" style="margin-bottom: 5px;">
            <input name="items[{{ uuid }}][custom]" type="text" class="form-control" placeholder="Custom Field">
        </td>
        <td class="btn-column">
            <button class="btn btn-default btn-sm" role="remove-item" data-uuid="{{ uuid }}">Remove</button>
        </td>
    </tr>
</script>