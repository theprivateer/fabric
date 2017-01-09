<script id="item-row" type="text/x-handlebars-template">
    <tr id="item-{{ uuid }}">
        <td class="sort-handle">
            <i class="icon-arrows"></i>
            <input type="hidden" name="items[{{ uuid }}][sort]" role="sort-order">
            <input type="hidden" name="items[{{ uuid }}][model_type]" value="{{ class }}">
            <input type="hidden" name="items[{{ uuid }}][model_id]" value="{{ class_id }}">
        </td>
        <td class="btn-column text-muted"><small>{{ class_basename }}</small></td>
        <td>{{ name }}</td>
        <td class="btn-column">
            <button class="btn btn-default btn-sm" role="remove-item" data-uuid="{{ uuid }}">Remove</button>
        </td>
    </tr>
</script>