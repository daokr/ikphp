function ToggleCheck(source)
{
    $('input[type=checkbox]').each(function(){this.checked=source.checked;});
}
