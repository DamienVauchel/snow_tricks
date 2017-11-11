$(document).ready(function()
{
    var $container = $('div#trick_edit_images');

    var $addLink = $('<a href="#" id="edit_images" class="btn btn-default">Ajouter une image</a>');
    $container.append($addLink);

    $addLink.click(function(e)
    {
        addCategory($container);
        e.preventDefault();
        return false;
    });

    var index = $container.find(':input').length;

    if (index == 0)
    {
        addCategory($container);
    }
    else
    {
        $container.children('div').each(function()
        {
            addDeleteLink($(this));
        });
    }

    function addCategory($container)
    {
        var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Image n°' + (index+1))
            .replace(/__name__/g, index));
        addDeleteLink($prototype);
        $container.append($prototype);
        index++;
    }

    function addDeleteLink($prototype)
    {
        var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');
        $prototype.append($deleteLink);

        $deleteLink.click(function(e)
        {
            $prototype.remove();
            e.preventDefault();
            return false;
        });
    }
});